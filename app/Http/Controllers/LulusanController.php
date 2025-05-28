<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LulusanModel;
use App\Models\SkalaModel;
use App\Models\InstansiModel;
use App\Models\KategoriModel;
use App\Models\ProfesiModel;

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
}