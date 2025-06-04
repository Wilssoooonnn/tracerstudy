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

        // $semuaSkala = SkalaModel::all();
        $record = FormlulusanModel::all()->where('alumni_id', $alumni->id)->first();
        // $semuaInstansi = InstansiModel::all();
        // $semuaKategori = KategoriModel::all();
        // $daftarProfesi = ProfesiModel::with('category')->get();
        $atasan = StakeholderModel::all()->where('alumni_id', $record->alumni_id)->first();


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

        try {
            // Validation
            $request->validate([
                'alumni' => 'required|string',
                'question' => 'required|array',
                'question.*' => 'required',
            ], [
                'alumni.required' => 'Alumni data is required.',
                'question.required' => 'Please answer all questions.',
                'question.*.required' => 'All questions must have a response.',
            ]);

            // Parse Alumni Data
            $alumniInput = $request->input('alumni');
            $alumniParts = explode(' - ', $alumniInput);
            $nim = isset($alumniParts[1]) ? trim($alumniParts[1]) : null;

            if (!$nim) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid alumni data provided. NIM not found.'
                ], 400);
            }

            // Find Alumni
            $alumni = LulusanModel::where('NIM', $nim)->first();
            if (!$alumni) {
                return response()->json([
                    'status' => false,
                    'message' => 'Alumni not found for NIM: ' . $nim
                ], 404);
            }

            // Find Form Lulusan
            $formLulusan = FormlulusanModel::where('alumni_id', $alumni->id)->first();
            if (!$formLulusan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Form lulusan record not found for this alumni.'
                ], 404);
            }

            $stakeholder = StakeholderModel::where('alumni_id', $alumni->id)->first();

            if (!$stakeholder) {

                // Debug: Lihat semua stakeholder yang ada
                $allStakeholders = StakeholderModel::select('id', 'alumni_id')->get();

                // Coba cari dengan form_lulusan_id jika kolom tersebut ada
                $stakeholder = StakeholderModel::where('form_lulusan_id', $formLulusan->id)->first();

                if (!$stakeholder) {
                    $stakeholder = StakeholderModel::create([
                        'alumni_id' => $alumni->id,
                        // Tambahkan field lain yang diperlukan sesuai struktur tabel
                    ]);
                }
            }

            if (!$stakeholder) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stakeholder not found and could not be created.'
                ], 404);
            }


            // Process Questions
            $questions = $request->input('question', []);
            $savedCount = 0;

            foreach ($questions as $pertanyaan_id => $respon) {
                $question = PertanyaanModel::find($pertanyaan_id);
                if (!$question) {
                    continue;
                }

                $responData = [
                    'pertanyaan_id' => $pertanyaan_id,
                    'respon' => $respon,
                    'stakeholder_id' => $stakeholder->id,
                ];

                try {
                    $createdRespon = Respon::create($responData);
                    $savedCount++;
                } catch (\Exception $e) {
                    throw $e;
                }
            }


            return response()->json([
                'status' => true,
                'message' => 'Responses successfully saved.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
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
