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
use App\Mail\StakeholderInvitation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class LulusanController extends Controller
{
    public function cekNim()
    {
        return view('lulusan.cek-nim');
    }

    public function getLulusanData(Request $request)
    {
        try {
            $query = LulusanModel::select(['id', 'nim', 'nama', 'programs_id', 'nohp', 'email', 'tanggal_lulus']);

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

            $totalRecords = LulusanModel::count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $query->skip($start)->take($length);

            $lulusan = $query->get();
            $totalFiltered = $request->has('search') && !empty($request->input('search.value')) ? $query->count() : $totalRecords;

            $data = $lulusan->map(function ($item) {
                $keterangan = empty($item->nohp) && empty($item->email) ? 'Belum Mengisi' : 'Sudah Mengisi';

                return [
                    'id' => $item->id,
                    'nim' => $item->nim,
                    'nama' => $item->nama,
                    'prodi' => $item->program ? $item->program->program_studi : '-',
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
                return response()->json(['status' => false, 'message' => 'Alumni not found.'], 404);
            }

            $token = Str::random(32);
            $lulusan->token = $token;
            $lulusan->token_expires_at = now()->addHours(24);
            $lulusan->save();

            Mail::to($lulusan->email)->send(new UndanganFormLulusan($lulusan, $token));

            return response()->json(['status' => true, 'message' => 'Token successfully sent to ' . $lulusan->email]);
        } catch (\Exception $e) {
            Log::error('Error in generateToken: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Failed to send token: ' . $e->getMessage()], 500);
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
        // Log incoming request data
        Log::info('Store request data:', $request->all());

        // Validate input
        try {
            $validated = $request->validate([
                'nim' => 'required|exists:data_alumni,nim',
                'no_hp' => 'required|string|max:20',
                'email' => 'required|email',
                'tanggal_pertama_kerja' => 'required|date_format:Y-m-d',
                'tanggal_mulai_kerja' => 'required|date_format:Y-m-d',
                'instansi_id' => 'required|exists:instansi,id',
                'nama_instansi' => 'required|string|max:255',
                'skala_id' => 'required|exists:skala,id', // Adjust to skala if needed
                'lokasi_instansi' => 'required|string|max:255',
                'kategori_id' => 'required|exists:category,id',
                'profesi_id' => 'nullable|exists:profesi,id',
                'profesi_input' => 'required_without:profesi_id|string|max:255',
                'nama_atasan' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'noHp_atasan' => 'required|string|max:20',
                'email_atasan' => 'required|email',
                'token' => 'required|string',
            ]);
            Log::info('Validation passed:', ['validated' => $validated]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', ['errors' => $e->errors(), 'input' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Verify alumni token
            $alumni = LulusanModel::where('nim', $request->nim)
                ->where('token', $request->token)
                ->where(function ($query) {
                    $query->whereNull('token_expires_at')
                        ->orWhere('token_expires_at', '>=', now());
                })
                ->first();

            if (!$alumni) {
                Log::warning('Invalid or expired token for NIM: ' . $request->nim);
                return redirect('/')->withErrors(['token' => 'Token tidak valid atau telah kedaluwarsa']);
            }
            Log::info('Alumni found:', ['alumni_id' => $alumni->id]);

            // Resolve profession
            $profesi = $this->resolveProfesi($request->profesi_input, $request->profesi_id, $request->kategori_id);
            if (!$profesi) {
                Log::error('Invalid profession for input: ' . $request->profesi_input);
                return back()->withErrors(['profesi_input' => 'Profesi tidak valid'])->withInput();
            }
            Log::info('Profession resolved:', ['profession_id' => $profesi->id]);

            // Update alumni data
            $alumni->nohp = $request->no_hp;
            $alumni->email = $request->email;
            $alumni->token = null;
            $alumni->token_expires_at = null;
            if (!$alumni->save()) {
                Log::error('Failed to update alumni ID: ' . $alumni->id);
                throw new \Exception('Gagal menyimpan data alumni.');
            }
            Log::info('Alumni updated:', ['alumni_id' => $alumni->id]);

            // Create Formlulusan record
            $formLulusan = FormlulusanModel::create([
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

            if (!$formLulusan) {
                Log::error('Failed to create Formlulusan for alumni ID: ' . $alumni->id);
                throw new \Exception('Gagal menyimpan data form lulusan.');
            }
            Log::info('Formlulusan created:', ['form_id' => $formLulusan->id]);

            // Generate unique token for stakeholder
            $stakeholderToken = Str::random(40);
            Log::info('Stakeholder token generated:', ['token' => $stakeholderToken]);

            // Create Stakeholder record
            $stakeholderData = [
                'nama' => $request->nama_atasan,
                'instansi' => $request->nama_instansi,
                'jabatan' => $request->jabatan,
                'email' => $request->email_atasan,
                'alumni_id' => $alumni->id,
                'token' => $stakeholderToken,
                'is_used' => false,
                'token_expires_at' => now()->addDays(7),
            ];
            Log::info('Attempting to create Stakeholder:', $stakeholderData);

            $stakeholder = StakeholderModel::create($stakeholderData);

            if (!$stakeholder) {
                Log::error('Failed to create Stakeholder for alumni ID: ' . $alumni->id);
                throw new \Exception('Gagal menyimpan data stakeholder.');
            }
            Log::info('Stakeholder created:', ['stakeholder_id' => $stakeholder->id]);

            // Generate invitation link
            $invitationLink = route('instansi.form-instansi', ['token' => $stakeholderToken]); // Fixed parameter name
            Log::info('Invitation link generated:', ['link' => $invitationLink]);

            // Commit the transaction
            DB::commit();

            // Send invitation email (optional)
            try {
                Mail::to($request->email_atasan)->send(new StakeholderInvitation($invitationLink));
                Log::info('Stakeholder invitation email sent to: ' . $request->email_atasan);
            } catch (\Exception $e) {
                Log::warning('Failed to send stakeholder invitation email: ' . $e->getMessage());
            }

            return redirect('/')->with('success', 'Data berhasil disimpan. Invitation link: ' . $invitationLink);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    private function resolveProfesi($profesiNama, $profesiId, $kategoriId)
    {
        Log::info('resolveProfesi called:', [
            'profesi_input' => $profesiNama,
            'profesi_id' => $profesiId,
            'kategori_id' => $kategoriId,
        ]);

        // If profesi_id is provided and valid, use it
        if ($profesiId && ProfesiModel::where('id', $profesiId)->exists()) {
            $profesi = ProfesiModel::find($profesiId);
            Log::info('Profession found by ID:', ['profesi_id' => $profesiId]);
            return $profesi;
        }

        // Otherwise, find or create profession by name and category
        if ($profesiNama && $kategoriId) {
            $profesi = ProfesiModel::where('profesi', $profesiNama)
                ->where('category_id', $kategoriId)
                ->first();

            if ($profesi) {
                Log::info('Profession found by name and category:', [
                    'profesi' => $profesiNama,
                    'category_id' => $kategoriId,
                ]);
                return $profesi;
            }

            // Create new profession
            $profesi = ProfesiModel::create([
                'profesi' => $profesiNama,
                'category_id' => $kategoriId,
            ]);
            Log::info('Profession created:', ['profesi_id' => $profesi->id]);
            return $profesi;
        }

        Log::warning('Profession resolution failed: missing input', [
            'profesi_input' => $profesiNama,
            'profesi_id' => $profesiId,
            'kategori_id' => $kategoriId,
        ]);
        return null;
    }

    public function import_view()
    {
        return view('admin.lulusan_import');
    }


    public function lulusan_import(Request $request)
    {
        // Validate file
        $rules = [
            'file_lulusan' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'File tidak valid: ' . implode(', ', $validator->errors()->all())
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
                    if ($baris > 1) { // Skip header row
                        $program_studi = trim($value['A'] ?? '');
                        $nim = trim($value['B'] ?? '');
                        $nama = trim($value['C'] ?? '');
                        $tanggal_lulus = $value['D'] ?? null;
                        $email = trim($value['E'] ?? '');

                        // Validate required fields
                        if (empty($program_studi) || empty($nim) || empty($nama)) {
                            continue; // Skip rows with missing required fields
                        }

                        // Validate program_studi
                        if (!isset($semuaProdi[$program_studi])) {
                            \Log::warning("Program studi tidak ditemukan: {$program_studi}, baris: {$baris}");
                            continue; // Skip invalid program_studi
                        }

                        // Convert Excel date to Y-m-d format
                        $tanggal_lulus_formatted = null;
                        if (!empty($tanggal_lulus)) {
                            try {
                                if (is_numeric($tanggal_lulus)) {
                                    // Excel date (numeric)
                                    $tanggal_lulus_formatted = Date::excelToDateTimeObject($tanggal_lulus)->format('Y-m-d');
                                } else {
                                    // String date (e.g., "2023-12-25" or "25/12/2023")
                                    $parsedDate = \DateTime::createFromFormat('d/m/Y', $tanggal_lulus) ?: \DateTime::createFromFormat('Y-m-d', $tanggal_lulus);
                                    if ($parsedDate) {
                                        $tanggal_lulus_formatted = $parsedDate->format('Y-m-d');
                                    }
                                }
                            } catch (\Exception $e) {
                                \Log::warning("Invalid date format on row {$baris}: {$tanggal_lulus}");
                                continue; // Skip rows with invalid dates
                            }
                        }

                        // Validate email
                        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            \Log::warning("Invalid email on row {$baris}: {$email}");
                            continue; // Skip rows with invalid emails
                        }

                        $insert[] = [
                            'programs_id' => $semuaProdi[$program_studi],
                            'nim' => $nim,
                            'nama' => $nama,
                            'tanggal_lulus' => $tanggal_lulus_formatted,
                            'email' => $email ?: null, // Allow null if email is empty
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    LulusanModel::insertOrIgnore($insert);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport. ' . count($insert) . ' baris diproses.',
                        'data' => $insert
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data valid yang diimport.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak berisi data.'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error importing lulusan: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
            ]);
        }
    }
}
