<?php

namespace App\Http\Controllers;

use App\Models\SkalaModel;
use App\Models\LulusanModel;
use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use App\Models\InstansiModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use App\Models\FormlulusanModel;
use App\Models\StakeholderModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\UndanganFormLulusan;
use Illuminate\Support\Facades\Log;
class LulusanController extends Controller
{
    public function cekNim()
    {
        return view('lulusan.cek-nim');
    }

    public function getLulusanData(Request $request)
    {
        try {
            // Inisialisasi query
            $query = LulusanModel::select(['id', 'nim', 'nama', 'programs_id', 'nohp', 'email', 'tanggal_lulus']);

            // Menangani pencarian
            if ($request->has('search') && !empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nim', 'LIKE', "%{$search}%")
                        ->orWhere('nama', 'LIKE', "%{$search}%")
                        ->orWhere('nohp', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('tanggal_lulus', 'LIKE', "%{$search}%");
                });
            }

            // Mendapatkan jumlah total data sebelum filter
            $totalRecords = LulusanModel::count();

            // Penerapan pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $query->skip($start)->take($length);

            // Mendapatkan data yang difilter
            $lulusan = $query->get();
            $totalFiltered = $request->has('search') && !empty($request->input('search.value')) ? $query->count() : $totalRecords;

            // Map data untuk DataTables
            $data = $lulusan->map(function ($item) {
                $keterangan = '';
                if (empty($item->nohp) && empty($item->email)) {
                    $keterangan = 'Belum Mengisi';
                } else {
                    $keterangan = 'Sudah Mengisi';
                }
                
                return [
                    'id' => $item->id,
                    'nim' => $item->nim,
                    'nama' => $item->nama,
                    'prodi' => $item->program ? $item->program->program_studi : '-',
                    // 'nohp' => $item->nohp ?? '-',
                    // 'email' => $item->email ?? '-',
                    'tanggal_lulus' => $item->tanggal_lulus ?? '-',
                    'keterangan' => $keterangan,
                    'action' => '<button class="btn btn-primary btn-sm" onclick="kirimToken(' . $item->id . ')">Kirim Token</button>'
                ];
            })->toArray();

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getLulusanData: ' . $e->getMessage());
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateToken($id)
    {
        try {
            $lulusan = LulusanModel::find($id);
            if (!$lulusan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Alumni not found.'
                ], 404);
            }

            $token = Str::random(32);
            $lulusan->token = $token;
            $lulusan->token_expires_at = now()->addHours(24);
            $lulusan->save();

            Mail::to($lulusan->email)->send(new UndanganFormLulusan($lulusan, $token));

            return response()->json([
                'status' => true,
                'message' => 'Token successfully sent to ' . $lulusan->email
            ]);
        } catch (\Exception $e) {
            Log::error('Error in generateToken: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to send token: ' . $e->getMessage()
            ], 500);
        }
    }
    public function submitCekNim(Request $request)
    {
        $request->validate(['nim' => 'required|string']);
        $lulusan = LulusanModel::where('nim', $request->nim)->first();
        if (!$lulusan) {
            return redirect()->back()->withErrors(['nim' => 'NIM not found.']);
        }
        $token = $lulusan->token ?? Str::random(32);
        $lulusan->token = $token;
        $lulusan->save();
        return redirect()->route('lulusan.form.lulusan', ['token' => $token]);
    }

    // Menampilkan form lulusan dengan data sudah terisi

    public function showFormLulusan($token)
    {
        $alumni = LulusanModel::where('token', $token)
            ->where(function ($query) {
                $query->whereNull('token_expires_at')
                    ->orWhere('token_expires_at', '>=', now());
            })
            ->first();

        if (!$alumni) {
            return redirect('/')->with('error', 'Token tidak valid atau telah kedaluwarsa!');
        }

        $semuaSkala = SkalaModel::all();
        $semuaInstansi = InstansiModel::all();
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();

        return view('lulusan.form-lulusan', [
            'nim' => $alumni->NIM,
            'alumni' => $alumni,
            'program_nama' => $alumni->program->program_studi ?? '-',
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'email' => $alumni->email,
            'tanggal_lulus' => $alumni->tanggal_lulus,
            'skala_id' => $alumni->skala_id,
            'semuaSkala' => $semuaSkala,
            'semuaInstansi' => $semuaInstansi,
            'semuaKategori' => $semuaKategori,
            'daftarProfesi' => $daftarProfesi,
            'token' => $token
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:data_alumni,nim',
            'no_hp' => 'required|max:20',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_kerja' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'nama_instansi' => 'required',
            'skala_id' => 'required|exists:skala,id',
            'lokasi_instansi' => 'required',
            'kategori_id' => 'required|exists:category,id',
            'profesi_id' => 'nullable',
            'profesi_input' => 'required_without:profesi_id|string|max:255',
            'nama_atasan' => 'required',
            'jabatan' => 'required',
            'noHp_atasan' => 'required',
            'email_atasan' => 'required|email',
            'token' => 'required|string'
        ]);

        $alumni = LulusanModel::where('nim', $request->nim)
            ->where('token', $request->token)
            ->where(function ($query) {
                $query->whereNull('token_expires_at')
                    ->orWhere('token_expires_at', '>=', now());
            })
            ->first();

        if (!$alumni) {
            return redirect('/')->withErrors(['token' => 'Token tidak valid atau telah kedaluwarsa']);
        }

        $profesi = $this->resolveProfesi($request->profesi_input, $request->profesi_id, $request->kategori_id);
        if (!$profesi) {
            return back()->withErrors(['profesi_input' => 'Profesi tidak valid']);
        }

        $alumni->nohp = $request->no_hp;
        $alumni->email = $request->email;
        $alumni->token = null;
        $alumni->token_expires_at = null;
        $alumni->save();

        FormlulusanModel::create([
            'alumni_id' => $alumni->id,
            'first_job_date' => $request->tanggal_pertama_kerja,
            'current_instansi_start_date' => $request->tanggal_mulai_kerja,
            'instansi_type' => $request->instansi_id,
            'instansi_name' => $request->nama_instansi,
            'instansi_scale' => $request->skala_id,
            'instansi_location' => $request->lokasi_instansi,
            'category_profession' => $request->kategori_id,
            'profession_id' => $profesi->id,
            'nama_atasan' => $request->nama_atasan,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->noHp_atasan,
            'email' => $request->email_atasan,
        ]);

        StakeholderModel::create([
            'nama' => $request->nama_atasan,
            'instansi' => $request->nama_instansi,
            'jabatan' => $request->jabatan,
            'email' => $request->email_atasan,
            'alumni_id' => $alumni->id
        ]);

        return redirect('/')->with('success', 'Data berhasil disimpan.');
    }

    private function resolveProfesi($profesiNama, $profesiId, $kategoriId)
    {
        if ($profesiId && is_numeric($profesiId)) {
            return ProfesiModel::find($profesiId);
        }

        return ProfesiModel::firstOrCreate(
            ['profesi' => $profesiNama],
            ['category_id' => $kategoriId]
        );
    }

    public function import_view()
    {
        return view('admin.lulusan_import');
    }


    public function lulusan_import(Request $request)
    {
        // Validasi file
        $rules = [
            'file_lulusan' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'File tidak valid!'
            ]);
        }

        try {
            $file = $request->file('file_lulusan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $semuaProdi = DB::table('programs')->pluck('id', 'program_studi')->toArray();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $program_studi = trim($value['A']);
                        $tanggal_lulus = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['D'])->format('Y-m-d'); // Convert Excel date to PHP DateTime object

                        $insert[] = [
                            'programs_id' => $semuaProdi[$program_studi],
                            'nim' => $value['B'],
                            'nama' => $value['C'],
                            'tanggal_lulus' => $tanggal_lulus, // Correctly formatted date
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    LulusanModel::insertOrIgnore($insert);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport.',
                        'data' => $insert
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak berisi data.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file. ' . $e->getMessage()
            ]);
        }
    }


}