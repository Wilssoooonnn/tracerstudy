<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LulusanModel;

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

        return view('lulusan.form-lulusan', [
            'alumni' => $alumni,
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'tanggal_lulus' => $alumni->tanggal_lulus,
        ]);
    }
}
