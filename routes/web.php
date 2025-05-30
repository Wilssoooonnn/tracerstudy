<?php
// routes/web.php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\PertanyaanController;

// Public routes
Route::redirect('/', '/welcome');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Public admin routes (no auth required)
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
        Route::get('generate-link-penggunalulusan', [AuthController::class, 'generate_link_penggunalulusan'])
            ->name('generate-link-penggunalulusan');
        Route::get('pertanyaan', [AuthController::class, 'pertanyaan'])->name('pertanyaan');
        Route::get('response-data', [AuthController::class, 'response_data'])->name('response-data');
        Route::get('rekap-hasil-lulusan', [AuthController::class, 'rekap_hasil_lulusan'])->name('rekap-hasil-lulusan');
        Route::get('rekap-hasil-surveykepuasan', [AuthController::class, 'rekap_hasil_surveykepuasan'])
            ->name('rekap-hasil-surveykepuasan');
        Route::get('rekap-belum-mengisi-lulusan', [AuthController::class, 'rekap_belum_mengisi_lulusan'])
            ->name('rekap-belum-mengisi-lulusan');
        Route::get('rekap-belum-mengisi-pengguna', [AuthController::class, 'rekap_belum_mengisi_pengguna'])
            ->name('rekap-belum-mengisi-pengguna');        
    });
});

Route::prefix('lulusan')->name('lulusan.')->group(function() {
    Route::get('/form-lulusan', function () {
        return view('lulusan.form-lulusan');
    })->name('form-lulusan');
    Route::get('/cek-nim', [LulusanController::class, 'cekNim'])->name('cek-nim.form');
    Route::post('/cek-nim', [LulusanController::class, 'submitCekNim'])->name('cek-nim.submit');
    // Form lulusan dengan data sudah terisi
    Route::get('/form-lulusan/{nim}', [LulusanController::class, 'showFormLulusan'])->name('form-lulusan');
    Route::post('/store', [LulusanController::class, 'store'])->name('store');

    
});

Route::prefix('pertanyaan')->name('pertanyaan')->group(function() {
    Route::get('/', [PertanyaanController::class, 'index']);          // menampilkan halaman awal pertanyaan
    Route::post('/list', [PertanyaanController::class, 'list']);      // menampilkan data pertanyaan dalam bentuk json untuk datatables
    Route::get('/create', [PertanyaanController::class, 'create']);   // menampilkan halaman form tambah pertanyaan
    Route::post('/', [PertanyaanController::class, 'store']);         // menyimpan data pertanyaan baru
    Route::get('/{id}', [PertanyaanController::class, 'show']);       // menampilkan detail pertanyaan
    Route::get('/{id}/edit', [PertanyaanController::class, 'edit']);  // menampilkan halaman form edit pertanyaan
    Route::put('/{id}', [PertanyaanController::class, 'update']);     // menyimpan perubahan data pertanyaan
    Route::delete('/{id}', [PertanyaanController::class, 'destroy']); // menghapus data pertanyaan
});
