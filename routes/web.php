<?php
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\KategoriProfesiController;

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

        // Alumni routes
        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('data', [AlumniController::class, 'index'])->name('data'); // View Alumni Data
            Route::get('create', [AlumniController::class, 'create'])->name('create'); // Form to Create Alumni
            Route::post('store', [AlumniController::class, 'store'])->name('store'); // Store new Alumni
            Route::get('edit/{id}', [AlumniController::class, 'edit'])->name('edit'); // Form to Edit Alumni
            Route::post('update/{id}', [AlumniController::class, 'update'])->name('update'); // Update Alumni
            Route::delete('destroy/{id}', [AlumniController::class, 'destroy'])->name('destroy'); // Delete Alumni
            Route::get('generate-link', [AlumniController::class, 'generateLink'])->name('generate-link'); // Generate Link for Alumni
        });

        // Other Admin-related routes (e.g., Instansi, Kategori Profesi)
        Route::resource('program_studi', ProgramStudiController::class);
        Route::resource('instansi', InstansiController::class);
        Route::resource('kategori_profesi', KategoriProfesiController::class);
    });
});
