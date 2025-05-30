<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LulusanModel;
use App\Models\SkalaModel;
use App\Models\InstansiModel;
use App\Models\KategoriModel;
use App\Models\ProfesiModel;

class InstansiController extends Controller
{
    public function cekLulusan()
    {
        return view('instansi.cek-lulusan');
    }

    public function submitCekLulusan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
        ]);

        $inputNama = strtolower(trim($request->nama));

        $alumni = LulusanModel::whereRaw('LOWER(nama) = ?', [$inputNama])->first();

        if (!$alumni) {
            return back()->with('error', 'Nama lulusan tidak ditemukan atau tidak valid. Input: ' . $request->nama);
        }

        return redirect()->route('instansi.form-instansi', ['nama' => urlencode($alumni->nama)]);
    }

    public function showFormInstansi($nama)
    {
        $nama = urldecode($nama);

        $alumni = LulusanModel::with('program')->where('nama', $nama)->first();

        if (!$alumni) {
            return redirect()->route('instansi.cek-lulusan')->withErrors(['nama' => 'Nama tidak ditemukan']);
        }

        $semuaSkala = SkalaModel::all();
        $semuaInstansi = InstansiModel::all();
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();

        return view('instansi.form-instansi', [
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
        $request->validate([
            'nim' => 'required|exists:lulusan,nim',
            'no_hp' => 'required|max:20',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'skala_id' => 'required|exists:skala,id',
            'categori_id' => 'required|exists:categori,id',
            'profesi_id' => 'required',
            'profesi_baru' => 'required_if:profesi_id,lainnya|max:255',
        ]);

        // Menentukan ID profesi baru atau yang dipilih
        if ($request->profesi_id === 'lainnya') {
            $profesiBaru = ProfesiModel::create([
                'profesi' => $request->profesi_baru,
                'category_id' => 1
            ]);
            $profesi_id = $profesiBaru->id;
        } else {
            $profesi_id = $request->profesi_id;
        }

        // Simpan data lulusan
        $alumni = LulusanModel::where('nim', $request->nim)->first();
        $alumni->no_hp = $request->no_hp;
        $alumni->email = $request->email;
        $alumni->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
        $alumni->instansi_id = $request->instansi_id;
        $alumni->skala_id = $request->skala_id;
        $alumni->kategori_id = $request->kategori_id;
        $alumni->profesi_id = $profesi_id;

        $alumni->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
}
