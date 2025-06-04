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
use Illuminate\Database\Eloquent\Collection;
use App\Models\FormlulusanModel;
use App\Models\StakeholderModel;

class LulusanController extends Controller
{
    public function cekNim()
    {
        return view('lulusan.cek-nim');
    }

    public function submitCekNim(Request $request)
    {
        $request->validate([
            'nim' => 'required',
        ]);

        $mahasiswa = LulusanModel::where('NIM', $request->nim)->first();

        if (!$mahasiswa) {
            return back()->with('error', 'NIM tidak ditemukan.');
        }

        return redirect()->route('lulusan.form-lulusan', ['nim' => $request->nim]);
    }

    // Menampilkan form lulusan dengan data sudah terisi

    public function showFormLulusan($nim)
    {
        $alumni = LulusanModel::with('program')->where('nim', $nim)->first();

        if (!$alumni) {
            return redirect()->route('cari-nim.form')->withErrors(['nim' => 'NIM tidak ditemukan']);
        }

        $semuaSkala = SkalaModel::all(); // ambil semua data skala
        $semuaInstansi = InstansiModel::all(); // ambil semua data instansi
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();

        return view('lulusan.form-lulusan', [
            'nim' => $nim,
            'alumni' => $alumni,
            'program_nama' => $alumni->program->program_studi ?? '-', // pakai nama kolom dari tabel programs
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'tanggal_lulus' => $alumni->tanggal_lulus,
            'skala_id' => $alumni->skala_id,
            'semuaSkala' => $semuaSkala, // kirim ke view
            'semuaInstansi' => $semuaInstansi, // kirim ke view
            'semuaKategori' => $semuaKategori,
            'daftarProfesi' => $daftarProfesi,
        ]);
    }

    public function store(Request $request)
    {
        // Validation rules
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
        ]);

        // Resolve the profession (profesi) based on input or ID
        $profesi = $this->resolveProfesi($request->profesi_input, $request->profesi_id, $request->kategori_id);

        if (!$profesi) {
            return back()->withErrors(['profesi_text' => 'Profesi tidak valid']);
        }

        // Fetch alumni by nim
        $alumni = LulusanModel::where('nim', $request->nim)->first();
        if (!$alumni) {
            return back()->withErrors(['nim' => 'Alumni tidak ditemukan']);
        }

        // Update alumni data
        $alumni->nohp = $request->no_hp;
        $alumni->email = $request->email;
        $alumni->save();

        // Insert into FormlulusanModel
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

        // Insert into StakeholderModel
        StakeholderModel::create([
            'nama' => $request->nama_atasan,
            'instansi' => $request->nama_instansi,
            'jabatan' => $request->jabatan,
            'email' => $request->email_atasan,
            'alumni_id' => $alumni->id
        ]);

        // Return success response
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Resolve the profession (profesi) based on input or ID.
     *
     * @param string|null $profesiNama
     * @param string|null $profesiId
     * @param string $kategoriId
     * @return ProfesiModel|null
     */
    private function resolveProfesi($profesiNama, $profesiId, $kategoriId)
    {
        if ($profesiId && is_numeric($profesiId)) {
            return ProfesiModel::findOrFail($profesiId);
        }

        return ProfesiModel::firstOrCreate(
            ['profesi' => $profesiNama],
            ['category_id' => $kategoriId]
        );
    }

    public function getLulusanData(Request $request)
    {
        // Mengambil data lulusan dengan kolom yang sesuai
        $lulusan = LulusanModel::select(['id', 'nim', 'nama', 'programs_id', 'nohp', 'email', 'tanggal_lulus'])->get();

        // Menyusun data dalam format yang sesuai untuk DataTables
        $data = $lulusan->map(function ($item) {
            return [
                'id' => $item->id,
                'nim' => $item->nim,
                'nama' => $item->nama,
                'prodi' => $item->program->program_studi ?? '-',
                'nohp' => $item->nohp,
                'email' => $item->email,
                'tanggal_lulus' => $item->tanggal_lulus
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $lulusan->count(),
            'recordsFiltered' => $lulusan->count(),
            'data' => $data, // Mengembalikan data yang sudah diformat
        ]);
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