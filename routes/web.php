<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\RekapLulusanController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\ChartController;

// Public route
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Public admin routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    // Authenticated admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::get('data-lulusan', [AuthController::class, 'data_lulusan'])->name('data-lulusan');
        Route::get('generate-link-lulusan', [AuthController::class, 'generate_link_lulusan'])->name('generate-link-lulusan');
        Route::get('data-stakeholder', [AuthController::class, 'data_stakeholder'])->name('data-stakeholder');
        Route::get('generate-link-penggunalulusan', [AuthController::class, 'generate_link_penggunalulusan'])->name('generate-link-penggunalulusan');
        Route::get('pertanyaan', [AuthController::class, 'pertanyaan'])->name('pertanyaan');
        Route::get('response-data', [AuthController::class, 'response_data'])->name('response-data');
        Route::get('rekap-hasil-lulusan', [AuthController::class, 'rekap_hasil_lulusan'])->name('rekap-hasil-lulusan');
        Route::get('rekap-hasil-surveykepuasan', [AuthController::class, 'rekap_hasil_surveykepuasan'])->name('rekap-hasil-surveykepuasan');
        Route::get('rekap-belum-mengisi-lulusan', [AuthController::class, 'rekap_belum_mengisi_lulusan'])->name('rekap-belum-mengisi-lulusan');
        Route::get('rekap-belum-mengisi-pengguna', [AuthController::class, 'rekap_belum_mengisi_pengguna'])->name('rekap-belum-mengisi-pengguna');

        Route::post('generate-token/{id}', [LulusanController::class, 'generateToken'])->name('generate-token');
    });
});

// Lulusan routes
Route::prefix('lulusan')->name('lulusan.')->group(function () {
    Route::get('/data', [LulusanController::class, 'getLulusanData'])->name('data');
    Route::get('/cek-nim', [LulusanController::class, 'cekNim'])->name('cek-nim.form');
    Route::post('/cek-nim', [LulusanController::class, 'submitCekNim'])->name('cek-nim.submit');
    Route::get('/form-lulusan/{token}', [LulusanController::class, 'showFormLulusan'])->name('form-lulusan');
    Route::post('/store', [LulusanController::class, 'store'])->name('store');
});

// Import routes for lulusan
Route::get('data-lulusan/import', [LulusanController::class, 'import_view'])->name('lulusan_import_view');
Route::post('data-lulusan/import', [LulusanController::class, 'lulusan_import'])->name('lulusan_import_post');

// Chart routes
Route::get('/chart/top-profesi', [ChartController::class, 'topProfesi'])->name('chart.topProfesi');
Route::get('/chart/jenis-instansi', [ChartController::class, 'jenisInstansi'])->name('chart.jenisInstansi');

// Pertanyaan routes
Route::prefix('pertanyaan')->name('pertanyaan.')->group(function () {
    Route::get('/', [PertanyaanController::class, 'index'])->name('index');
    Route::post('/list', [PertanyaanController::class, 'list'])->name('list');
    Route::get('/create', [PertanyaanController::class, 'create'])->name('create');
    Route::post('/', [PertanyaanController::class, 'store'])->name('store');
    Route::get('/{id}', [PertanyaanController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PertanyaanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PertanyaanController::class, 'update'])->name('update');
    Route::delete('/{id}', [PertanyaanController::class, 'destroy'])->name('destroy');
});

// Instansi routes
Route::prefix('instansi')->name('instansi.')->group(function () {
    Route::get('/cek-lulusan', [InstansiController::class, 'cekLulusan'])->name('cek-lulusan');
    Route::post('/cek-lulusan', [InstansiController::class, 'submitCekLulusan'])->name('cek-lulusan.submit');
    Route::get('/form-instansi/{nama}', [InstansiController::class, 'showFormInstansi'])->name('form-instansi');
    Route::post('/store', [InstansiController::class, 'store'])->name('store');
    Route::get('/data-stakeholder', [InstansiController::class, 'index'])->name('index');
    Route::get('/list', [InstansiController::class, 'list'])->name('list');
    Route::get('/{id}', [InstansiController::class, 'show'])->name('show');
});

// Rekap lulusan routes
Route::prefix('rekaplulusan')->name('rekaplulusan.')->group(function () {
    Route::get('/', [RekapLulusanController::class, 'index'])->name('index');
    Route::post('/list', [RekapLulusanController::class, 'list'])->name('list');
    Route::get('/create', [RekapLulusanController::class, 'create'])->name('create');
    Route::post('/', [RekapLulusanController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RekapLulusanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RekapLulusanController::class, 'update'])->name('update');
    Route::delete('/{id}', [RekapLulusanController::class, 'destroy'])->name('destroy');
    Route::get('/export_excel', [RekapLulusanController::class, 'export_excel'])->name('export_excel');
    Route::get('/export_excel_pengguna', [RekapLulusanController::class, 'export_excel_pengguna'])->name('export_excel_pengguna');
});

// Rekap hasil tracer study
Route::prefix('rekaphasil')->name('rekaphasil.')->group(function () {
    Route::get('/', [TracerStudyController::class, 'index'])->name('index');
    Route::post('/list', [TracerStudyController::class, 'list'])->name('list');
    Route::get('/export-rekap-tracer-study', [TracerStudyController::class, 'export_rekap_tracer_study'])->name('export');
    Route::get('/{id}', [TracerStudyController::class, 'show'])->name('show');
});

// Response routes
Route::prefix('response')->name('response.')->group(function () {
    Route::get('/', [ResponseController::class, 'index'])->name('index');
    Route::post('/list', [ResponseController::class, 'list'])->name('list');
    Route::get('/create', [ResponseController::class, 'create'])->name('create');
    Route::post('/', [ResponseController::class, 'store'])->name('store');
    Route::get('/{id}', [ResponseController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ResponseController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ResponseController::class, 'update'])->name('update');
    Route::delete('/{id}', [ResponseController::class, 'destroy'])->name('destroy');
});

// Rekap pengguna lulusan yang belum mengisi
Route::prefix('rekapbelummengisipenggunalulusan')->name('rekapbelummengisipenggunalulusan.')->group(function () {
    Route::get('/', [RekapLulusanController::class, 'index'])->name('index');
    Route::post('/list', [RekapLulusanController::class, 'list'])->name('list');
    Route::get('/export_excel', [RekapLulusanController::class, 'export_excel_pengguna'])->name('export_excel');
});
