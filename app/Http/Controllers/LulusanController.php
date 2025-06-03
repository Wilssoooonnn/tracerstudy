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

    public function showFormLulusan($nim)
    {
        $alumni = LulusanModel::with('program')->where('nim', $nim)->first();

        if (!$alumni) {
            return redirect()->route('cari-nim.form')->withErrors(['nim' => 'NIM tidak ditemukan']);
        }

        $semuaSkala = SkalaModel::all();
        $semuaInstansi = InstansiModel::all();
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();

        return view('lulusan.form-lulusan', [
            'nim' => $nim,
            'alumni' => $alumni,
            'program_nama' => $alumni->program->program_studi ?? '-',
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'tanggal_lulus' => $alumni->tanggal_lulus,
            'skala_id' => $alumni->skala_id,
            'semuaSkala' => $semuaSkala,
            'semuaInstansi' => $semuaInstansi,
            'semuaKategori' => $semuaKategori,
            'daftarProfesi' => $daftarProfesi,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nim' => 'required|exists:data_alumni,NIM',
                'no_hp' => 'required|max:20',
                'email' => 'required|email',
            ]);

            // Perbarui data alumni di tabel data_alumni
            $alumni = LulusanModel::where('NIM', $request->nim)->first();
            if (!$alumni) {
                return redirect()->back()->with('error', 'Alumni tidak ditemukan.');
            }

            $alumni->nohp = $request->no_hp;
            $alumni->email = $request->email;
            $alumni->save();

            return redirect()->route('lulusan.form-lulusan', ['nim' => $request->nim])
                ->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function getLulusanData(Request $request)
    {
        $lulusan = LulusanModel::select(['id', 'nim', 'nama', 'programs_id', 'nohp', 'email'])->get();

        $data = $lulusan->map(function ($item) {
            return [
                'id' => $item->id,
                'nim' => $item->nim,
                'nama' => $item->nama,
                'prodi' => $item->program->program_studi ?? '-',
                'nohp' => $item->nohp,
                'email' => $item->email,
                'action' => '<button>Edit</button>',
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $lulusan->count(),
            'recordsFiltered' => $lulusan->count(),
            'data' => $data,
        ]);
    }

    public function import_view()
    {
        return view('admin.lulusan_import');
    }

    public function lulusan_import(Request $request)
    {
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
                        $insert[] = [
                            'programs_id' => $semuaProdi[$program_studi],
                            'nim' => $value['B'],
                            'nama' => $value['C'],
                            'tanggal_lulus' => $value['D'],
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