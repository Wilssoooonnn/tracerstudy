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
use App\Models\Respon;
use App\Models\pertanyaanModel;
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

        $pertanyaan = PertanyaanModel::all(); // Fetch all the questions

        return view('instansi.form-instansi', [
            'alumni' => $alumni,
            'program_nama' => $alumni->program->program_studi ?? '-',
            'programs_id' => $alumni->programs_id,
            'nama' => $alumni->nama,
            'nim' => $alumni->NIM,
            'nama_instansi' => $record->instansi_name ?? '-',
            'email' => $atasan->email,
            'nama_atasan' => $atasan->nama ?? '-',
            'jabatan' => $atasan->jabatan ?? '-',
            'pertanyaan' => $pertanyaan, // Correct way to pass the questions data to view
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'alumni' => 'required|string',
            'question' => 'required|array', // Ensure questions are provided as an array
            'question.*' => 'required', // Each question response must be provided
        ]);

        // Extract the alumni NIM from the input (assuming format: "nama - NIM - program")
        $alumniInput = explode(' - ', $request->input('alumni'));
        $nim = $alumniInput[1] ?? null;

        if (!$nim) {
            return back()->with('error', 'Invalid alumni data provided.');
        }

        // Find the alumni by NIM
        $alumni = LulusanModel::where('NIM', $nim)->first();
        if (!$alumni) {
            return back()->with('error', 'Alumni not found.');
        }

        // Find the formlulusan record for the alumni
        $formLulusan = FormlulusanModel::where('alumni_id', $alumni->id)->first();
        if (!$formLulusan) {
            return back()->with('error', 'Form lulusan record not found.');
        }

        // Find the stakeholder associated with the formlulusan
        $stakeholder = StakeholderModel::where('alumni_id', $formLulusan->id)->first();
        if (!$stakeholder) {
            return back()->with('error', 'Stakeholder not found.');
        }

        // Process each question response
        foreach ($request->input('question') as $pertanyaan_id => $respon) {
            // Ensure the pertanyaan_id exists
            if (!PertanyaanModel::find($pertanyaan_id)) {
                continue; // Skip if the question ID is invalid
            }

            // Save the response to the respon table
            Respon::create([
                'pertanyaan_id' => $pertanyaan_id,
                'respon' => $respon,
                'stakeholder_id' => $stakeholder->id,
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('instansi.cek-lulusan')->with('success', 'Responses successfully saved.');
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
