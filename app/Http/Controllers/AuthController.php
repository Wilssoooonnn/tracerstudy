<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return view('admin.dashboard', ['type_menu' => 'sidebar']);
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
    
    public function generate_link_penggunalulusan()
    {
        return view('admin.generate_link_penggunalulusan', ['type_menu' => 'sidebar']);
    }

    public function tambah_form()
    {
        return view('admin.tambah_form', ['type_menu' => 'sidebar']);
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
}