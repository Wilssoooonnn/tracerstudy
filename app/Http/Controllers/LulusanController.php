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
        $request->validate([
            'nim' => 'required|exists:lulusan,nim',
            'no_hp' => 'required|max:20',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'skala_id' => 'required|exists:skala,id',
            'kategori_id' => 'required|exists:kategori,id',
            'profesi_id' => 'required',
            'profesi_baru' => 'required_if:profesi_id,lainnya|max:255',
            // validasi lain sesuai form
        ]);

        if ($request->profesi_id === 'lainnya') {
            $profesiBaru = ProfesiModel::create([
                'profesi' => $request->profesi_baru,
                'category_id' => 1 // sesuaikan
            ]);
            $profesi_id = $profesiBaru->id;
        } else {
            $profesi_id = $request->profesi_id;
        }

        $alumni = LulusanModel::where('nim', $request->nim)->first();
        $alumni->no_hp = $request->no_hp;
        $alumni->email = $request->email;
        $alumni->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
        $alumni->instansi_id = $request->instansi_id;
        $alumni->skala_id = $request->skala_id;
        $alumni->kategori_id = $request->kategori_id;
        $alumni->profesi_id = $profesi_id;
        // Simpan field lain sesuai form

        $alumni->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function getLulusanData(Request $request)
    {
        // Mengambil data lulusan dengan kolom yang sesuai
        $lulusan = LulusanModel::select(['id', 'nim', 'nama', 'programs_id', 'nohp', 'email'])->get();

        // Menyusun data dalam format yang sesuai untuk DataTables
        $data = $lulusan->map(function ($item) {
            return [
                'id' => $item->id,
                'nim' => $item->nim,
                'nama' => $item->nama,
                'programs_id' => $item->programs_id, // Pastikan ini sesuai dengan kolom di database
                'nohp' => $item->nohp,
                'email' => $item->email,
                'action' => '<button>Edit</button>', // Sesuaikan dengan tombol aksi Anda
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