<?php

namespace App\Http\Controllers;

use App\Models\FormlulusanModel;
use App\Models\SkalaModel;
use App\Models\LulusanModel;
use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use App\Models\InstansiModel;
use App\Models\KategoriModel;
use App\Models\StakeholderModel;
use Yajra\DataTables\Facades\DataTables;

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

        return redirect()->route('instansi.form-instansi', [
            'nama' => urlencode($alumni->nama),
        ]);
    }

    public function showFormInstansi($nama)
    {
        $nama = urldecode($nama);

        $alumni = LulusanModel::with('program')->where('nama', $nama)->first();

        if (!$alumni) {
            return redirect()
                ->route('instansi.cek-lulusan')
                ->withErrors(['nama' => 'Nama tidak ditemukan']);
        }

        $semuaSkala = SkalaModel::all();
        $record = FormlulusanModel::all()->where('alumni_id', $alumni->id)->first();
        $semuaInstansi = InstansiModel::all();
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();
        $atasan = StakeholderModel::all()->where('alumni_id', $record->id)->first();


        return view('instansi.form-instansi', [
            'alumni' => $alumni,
            'program_nama' => $alumni->program->program_studi ?? '-',
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'nim' => $alumni->NIM,
            'tanggal_lulus' => $alumni->tanggal_lulus,
            'nama_instansi' => $record->instansi_name ?? '-',
            'email' => $atasan->email,
            'skala_id' => $record->instansi_scale ?? '-',
            'nama_atasan' => $atasan->nama ?? '-',
            'jabatan' => $atasan->jabatan ?? '-',
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
            'kategori_id' => 'required|exists:category,id',
            'profesi_id' => 'required',
            'profesi_baru' => 'required_if:profesi_id,lainnya|max:255',
            'nama_instansi' => 'required|string|max:255',
            'nama_atasan' => 'required|string|max:255',
            'no_hp_atasan' => 'required|max:20',
            'email_atasan' => 'required|email',
        ]);

        if ($request->profesi_id === 'lainnya') {
            $profesiBaru = ProfesiModel::create([
                'profesi' => $request->profesi_baru,
                'category_id' => 1, // Sesuaikan dengan kategori default jika diperlukan
            ]);
            $profesi_id = $profesiBaru->id;
        } else {
            $profesi_id = $request->profesi_id;
        }

        // Simpan ke data lulusan
        $alumni = LulusanModel::where('nim', $request->nim)->first();
        $alumni->no_hp = $request->no_hp;
        $alumni->email = $request->email;
        $alumni->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
        $alumni->instansi_id = $request->instansi_id;
        $alumni->skala_id = $request->skala_id;
        $alumni->kategori_id = $request->kategori_id;
        $alumni->profesi_id = $profesi_id;
        $alumni->save();

        // Simpan data stakeholder (pengguna lulusan)
        StakeholderModel::create([
            'nim' => $request->nim,
            'nama_instansi' => $request->nama_instansi,
            'nama_atasan' => $request->nama_atasan,
            'no_hp_atasan' => $request->no_hp_atasan,
            'email_atasan' => $request->email_atasan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data berhasil disimpan.');
    }

    public function index()
    {
        return view('admin.data_stakeholder');
    }

    public function list(Request $request)
    {
        $stakeholders = StakeholderModel::with('lulusan')->get();

        return DataTables::of($stakeholders)
            ->addIndexColumn()
            ->addColumn('nama_lulusan', function ($row) {
                return $row->lulusan->nama ?? '-';
            })
            ->addColumn('action', function ($stakeholder) {
                return '<a href="' . url('/instansi/' . $stakeholder->id) . '" class="btn btn-primary btn-sm">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $stakeholder = StakeholderModel::with('lulusan')->findOrFail($id);
        return view('admin.stakeholder_show', compact('stakeholder'));
    }
}
