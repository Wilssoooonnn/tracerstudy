<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showLoginForm', 'login']);
    }

    public function showLoginForm()
    {
        return view('admin.login'); // No $type_menu needed for standalone login
    }

    public function login(Request $request)
    {
        Log::info('Session ID: ' . session()->getId());
        Log::info('CSRF Token: ' . $request->session()->token());
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function dashboard()
    {
        $totalAlumni = DB::table('data_alumni')->count();
        $totalAdmin = DB::table('admins')->count();
        $totalStakeholder = DB::table('data_stakeholder')->count();
        $totalTracerRecord = DB::table('tracer_record')->count();

        $sebaranData = DB::table('tracer_record as t')
            ->join('data_alumni as a', 'a.id', '=', 't.alumni_id')
            ->join('programs as p', 'p.id', '=', 'a.programs_id')
            ->selectRaw('
        p.program_studi,
        YEAR(a.tanggal_lulus) as tahun_lulus,
        COUNT(t.id) as jumlah_terlacak,
        SUM(CASE WHEN t.category_profession = 1 THEN 1 ELSE 0 END) as kerja_infokom,
        SUM(CASE WHEN t.category_profession = 2 THEN 1 ELSE 0 END) as kerja_non_infokom,
        SUM(CASE WHEN t.category_profession = 3 THEN 1 ELSE 0 END) as belum_bekerja,
        SUM(CASE WHEN t.instansi_scale = 1 THEN 1 ELSE 0 END) as international,
        SUM(CASE WHEN t.instansi_scale = 2 THEN 1 ELSE 0 END) as nasional,
        SUM(CASE WHEN t.instansi_scale = 3 THEN 1 ELSE 0 END) as wirausaha
    ')
            ->groupBy('p.program_studi', DB::raw('YEAR(a.tanggal_lulus)'))
            ->orderBy('tahun_lulus')
            ->get();


        $jumlahLulusan = DB::table('data_alumni as a')
            ->join('programs as p', 'p.id', '=', 'a.programs_id')
            ->selectRaw('p.program_studi, YEAR(a.tanggal_lulus) as tahun_lulus, COUNT(*) as jumlah')
            ->groupBy('p.program_studi', DB::raw('YEAR(a.tanggal_lulus)'))
            ->orderBy('tahun_lulus')
            ->get();

        $result = $sebaranData->map(function ($item) use ($jumlahLulusan) {
            $item->jumlah_lulusan = $jumlahLulusan->first(function ($jl) use ($item) {
                return $jl->tahun_lulus == $item->tahun_lulus && $jl->program_studi == $item->program_studi;
            })->jumlah ?? 0;
            return $item;
        });

        $masaTungguData = DB::table('tracer_record as t')
            ->join('data_alumni as a', 'a.id', '=', 't.alumni_id')
            ->join('programs as p', 'p.id', '=', 'a.programs_id')
            ->selectRaw('
        p.program_studi,
        YEAR(a.tanggal_lulus) as tahun,
        COUNT(t.id) as jumlah_terlacak,
        ROUND(AVG(TIMESTAMPDIFF(MONTH, a.tanggal_lulus, t.first_job_date)), 1) as rata_tunggu
    ')
            ->groupBy('p.program_studi', DB::raw('YEAR(a.tanggal_lulus)'))
            ->orderBy('tahun')
            ->get();


        $tunggu_result = $masaTungguData->map(function ($item) use ($jumlahLulusan) {
            $item->jumlah_lulusan = $jumlahLulusan->first(function ($jl) use ($item) {
                return $jl->tahun_lulus == $item->tahun && $jl->program_studi == $item->program_studi;
            })->jumlah ?? 0;
            return $item;
        });

        $survei = DB::table('respon as r')
            ->join('pertanyaan as p', 'p.id', '=', 'r.pertanyaan_id')
            ->where('p.question_type', 'scale')
            ->select(
                'p.id as pertanyaan_id',
                'p.pertanyaan',
                DB::raw('SUM(CASE WHEN r.respon = "1" THEN 1 ELSE 0 END) as sangat_kurang'),
                DB::raw('SUM(CASE WHEN r.respon = "2" THEN 1 ELSE 0 END) as kurang'),
                DB::raw('SUM(CASE WHEN r.respon = "3" THEN 1 ELSE 0 END) as cukup'),
                DB::raw('SUM(CASE WHEN r.respon = "4" THEN 1 ELSE 0 END) as baik'),
                DB::raw('SUM(CASE WHEN r.respon = "5" THEN 1 ELSE 0 END) as sangat_baik')
            )
            ->groupBy('p.id', 'p.pertanyaan')
            ->orderBy('p.id')
            ->get();

        $chartData = [];
        foreach ($survei as $item) {
            $chartData[$item->pertanyaan_id] = [
                'pertanyaan' => $item->pertanyaan,
                'data' => [
                    $item->sangat_kurang,
                    $item->kurang,
                    $item->cukup,
                    $item->baik,
                    $item->sangat_baik
                ]
            ];
        }

        $programs = DB::table('programs')->select('program_studi')->distinct()->get();

        $years = DB::table('data_alumni')
            ->selectRaw('YEAR(tanggal_lulus) as year')
            ->distinct()->pluck('year')->sort()->values();

        $yearRanges = $years->chunk(4)->map(function ($chunk) {
            return $chunk->first() . '-' . $chunk->last();
        });

        $dataAlumniJob = DB::table('tracer_record as t')
            ->join('category as c', 'c.id', '=', 't.category_profession')
            ->select('c.name', DB::raw('COUNT(*) as total'))
            ->groupBy('c.id', 'c.name')
            ->get();

        $dataInstansi = DB::table('tracer_record as t')
            ->join('instansi as i', 'i.id', '=', 't.instansi_type')
            ->select('i.instansi_nama', DB::raw('COUNT(*) as total'))
            ->groupBy('i.id', 'i.instansi_nama')
            ->get();

        $dataScale = DB::table('tracer_record as t')
            ->join('skala as s', 's.id', '=', 't.instansi_scale')
            ->select('s.skala_nama', DB::raw('COUNT(*) as total'))
            ->groupBy('s.id', 's.skala_nama')
            ->get();

        $dataProfesi = DB::table('data_alumni as a')
            ->leftJoin('tracer_record as t', 'a.id', '=', 't.alumni_id')
            ->leftJoin('profesi as p', 't.profession_id', '=', 'p.id')
            ->selectRaw('COALESCE(p.profesi, "Belum Bekerja") as profesi, COUNT(CASE WHEN p.profesi IS NULL THEN a.id ELSE t.id END) as total')
            ->groupBy('p.id', 'p.profesi')
            ->orderByDesc('total')
            ->get();

        $totalAlumni = DB::table('data_alumni')->count();
        $totalTracked = DB::table('tracer_record')->count();
        $untrackedCount = $totalAlumni - $totalTracked;
        if ($dataProfesi->where('profesi', 'Belum Bekerja')->isEmpty() && $untrackedCount > 0) {
            $dataProfesi->push((object) [
                'profesi' => 'Belum Bekerja',
                'total' => $untrackedCount
            ]);
        }

        $maxProfesi = $dataProfesi->max('total');

        $chartData = [];
        foreach ($survei as $item) {
            $chartData[$item->pertanyaan_id] = [
                'pertanyaan' => $item->pertanyaan,
                'data' => [
                    $item->sangat_kurang,
                    $item->kurang,
                    $item->cukup,
                    $item->baik,
                    $item->sangat_baik
                ]
            ];
        }

        return view('admin.dashboard', [
            'totalAlumni' => $totalAlumni,
            'totalAdmin' => $totalAdmin,
            'totalStakeholder' => $totalStakeholder,
            'totalTracerRecord' => $totalTracerRecord,
            'result' => $result,
            'tunggu_result' => $tunggu_result,
            'survei' => $survei,
            'dataAlumniJob' => $dataAlumniJob,
            'dataInstansi' => $dataInstansi,
            'dataScale' => $dataScale,
            'chartData' => $chartData,
            'type_menu' => 'sidebar',
            'dataProfesi' => $dataProfesi,
            'maxProfesi' => $maxProfesi,
            'jumlahLulusan' => $jumlahLulusan,
            'yearRanges' => $yearRanges,
            'programs' => $programs
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', ['admins' => $admins, 'type_menu' => 'sidebar']);
    }
    public function profile()
    {
        return view('admin.profile', ['type_menu' => 'sidebar']);
    }

    public function data_lulusan()
    {
        return view('admin.data_lulusan', ['type_menu' => 'sidebar']);
    }

    public function generate_link_lulusan()
    {
        return view('admin.generate_link_lulusan', ['type_menu' => 'sidebar']);
    }

    public function data_stakeholder()
    {
        return view('admin.data_stakeholder', ['type_menu' => 'sidebar']);
    }

    public function profesi()
    {
        return view('admin.profesi', ['type_menu' => 'sidebar']);
    }

    public function response_data()
    {
        return view('admin.response_data', ['type_menu' => 'sidebar']);
    }

    public function pertanyaan()
    {
        return view('admin.pertanyaan', ['type_menu' => 'sidebar']);
    }

    public function rekap_hasil_lulusan()
    {
        return view('admin.rekap_hasil_lulusan', ['type_menu' => 'sidebar']);
    }

    public function rekap_hasil_surveykepuasan()
    {
        return view('admin.rekap_hasil_surveykepuasan', ['type_menu' => 'sidebar']);
    }

    public function rekap_belum_mengisi_lulusan()
    {
        return view('admin.rekap_belum_mengisi_lulusan', ['type_menu' => 'sidebar']);
    }

    public function rekap_belum_mengisi_pengguna()
    {
        return view('admin.rekap_belum_mengisi_pengguna', ['type_menu' => 'sidebar']);
    }
}