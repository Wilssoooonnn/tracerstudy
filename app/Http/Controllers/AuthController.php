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
        $data = DB::table('tracer_record as t')
        ->join('data_alumni as a', 'a.id', '=', 't.alumni_id')
        ->selectRaw('
            YEAR(a.tanggal_lulus) as tahun_lulus,
            COUNT(t.id) as jumlah_terlacak,
            SUM(CASE WHEN t.category_profession = 1 THEN 1 ELSE 0 END) as kerja_infokom,
            SUM(CASE WHEN t.category_profession = 2 THEN 1 ELSE 0 END) as kerja_non_infokom,
            SUM(CASE WHEN t.instansi_scale = 3 THEN 1 ELSE 0 END) as multinasional,
            SUM(CASE WHEN t.instansi_scale = 2 THEN 1 ELSE 0 END) as nasional,
            SUM(CASE WHEN t.instansi_type = 4 THEN 1 ELSE 0 END) as wirausaha
        ')
        ->groupBy(DB::raw('YEAR(a.tanggal_lulus)'))
        ->orderBy('tahun_lulus')
        ->get();

    $jumlah_lulusan = DB::table('data_alumni')
        ->selectRaw('YEAR(tanggal_lulus) as tahun_lulus, COUNT(*) as jumlah')
        ->groupBy(DB::raw('YEAR(tanggal_lulus)'))
        ->pluck('jumlah', 'tahun_lulus'); // hasil: ['2021' => 213, '2022' => 180, ...]

    $sebaran = $data->map(function ($item) use ($jumlah_lulusan) {
        $item->jumlah_lulusan = $jumlah_lulusan[$item->tahun_lulus] ?? 0;
        return $item;
    });

    // table masa tunguu

        $alumni = DB::table('data_alumni')
        ->select('tanggal_lulus')
        ->selectRaw('YEAR(tanggal_lulus) as tahun_lulus')
        ->groupBy(DB::raw('YEAR(tanggal_lulus)'));
    
    $data = DB::table('tracer_record as t')
        ->join('data_alumni as a', 'a.id', '=', 't.alumni_id')
        ->selectRaw('
            YEAR(a.tanggal_lulus) as tahun,
            COUNT(t.id) as jumlah_terlacak,
            ROUND(AVG(TIMESTAMPDIFF(MONTH, a.tanggal_lulus, t.first_job_date))) as rata_tunggu
        ')
        ->groupBy(DB::raw('YEAR(a.tanggal_lulus)'))
        ->get();

    $jumlahLulusan = DB::table('data_alumni')
        ->selectRaw('YEAR(tanggal_lulus) as tahun, COUNT(*) as jumlah_lulusan')
        ->groupBy(DB::raw('YEAR(tanggal_lulus)'))
        ->pluck('jumlah_lulusan', 'tahun');

    // Gabung hasil tracer dan alumni
    $masaTunggu = $data->map(function ($item) use ($jumlahLulusan) {
        $item->jumlah_lulusan = $jumlahLulusan[$item->tahun] ?? 0;
        return $item;
    });

    // table survei
    $data = DB::table('respon as r')
        ->join('pertanyaan as p', 'p.id', '=', 'r.pertanyaan_id')
        ->whereBetween('r.pertanyaan_id', [1, 9])
        ->select(
            'p.pertanyaan',
            DB::raw('SUM(CASE WHEN r.respon = 1 THEN 1 ELSE 0 END) as sangat_kurang'),
            DB::raw('SUM(CASE WHEN r.respon = 2 THEN 1 ELSE 0 END) as kurang'),
            DB::raw('SUM(CASE WHEN r.respon = 3 THEN 1 ELSE 0 END) as cukup'),
            DB::raw('SUM(CASE WHEN r.respon = 4 THEN 1 ELSE 0 END) as baik'),
            DB::raw('SUM(CASE WHEN r.respon = 5 THEN 1 ELSE 0 END) as sangat_baik')
        )
        ->groupBy('p.pertanyaan')
        ->get();

    return view('admin.dashboard', [
    'result' => $sebaran,
    'tunggu_result' => $masaTunggu, // ini supaya di view ada variabel $tunggu_result
    'survei' => $data,
    'type_menu' => 'sidebar',
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