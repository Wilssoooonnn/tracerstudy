<?php
// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::redirect('/', '/welcome')->name('home');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Lulusan (Graduate) survey routes
Route::prefix('lulusan')->name('lulusan.')->group(function () {
    Route::get('form/{token}', [AlumniController::class, 'showForm'])->name('form.show');
    Route::post('form/{token}', [AlumniController::class, 'submitForm'])->name('form.submit');
});

// Penggunalulusan (Stakeholder) survey routes
Route::prefix('penggunalulusan')->name('penggunalulusan.')->group(function () {
    Route::get('form/{token}', [StakeholderController::class, 'showForm'])->name('form.show');
    Route::post('form/{token}', [StakeholderController::class, 'submitForm'])->name('form.submit');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Unauthenticated routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        // Profile management
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');

        // Lulusan (Graduate) management
        Route::prefix('data-lulusan')->name('data-lulusan.')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('index');
            Route::get('create', [AlumniController::class, 'create'])->name('create');
            Route::post('/', [AlumniController::class, 'store'])->name('store');
            Route::get('{lulusan}/edit', [AlumniController::class, 'edit'])->name('edit');
            Route::put('{lulusan}', [AlumniController::class, 'update'])->name('update');
            Route::delete('{lulusan}', [AlumniController::class, 'destroy'])->name('destroy');
            Route::get('{lulusan}/generate-link', [AlumniController::class, 'generateLink'])->name('generate-link');
        });

        // Stakeholder management
        Route::prefix('data-stakeholder')->name('data-stakeholder.')->group(function () {
            Route::get('/', [StakeholderController::class, 'index'])->name('index');
            Route::get('create', [StakeholderController::class, 'create'])->name('create');
            Route::post('/', [StakeholderController::class, 'store'])->name('store');
            Route::get('{stakeholder}/edit', [StakeholderController::class, 'edit'])->name('edit');
            Route::put('{stakeholder}', [StakeholderController::class, 'update'])->name('update');
            Route::delete('{stakeholder}', [StakeholderController::class, 'destroy'])->name('destroy');
            Route::get('{stakeholder}/generate-link', [StakeholderController::class, 'generateLink'])->name('generate-link');
        });

        // Question management
        Route::resource('pertanyaan', QuestionController::class)->except(['show']);

        // Result summaries
        Route::prefix('rekap')->name('rekap.')->group(function () {
            Route::get('hasil-lulusan', [RekapController::class, 'hasilLulusan'])->name('hasil-lulusan');
            Route::get('hasil-surveykepuasan', [RekapController::class, 'hasilSurveyKepuasan'])->name('hasil-surveykepuasan');
            Route::get('belum-mengisi-lulusan', [RekapController::class, 'belumMengisiLulusan'])->name('belum-mengisi-lulusan');
            Route::get('belum-mengisi-pengguna', [RekapController::class, 'belumMengisiPengguna'])->name('belum-mengisi-pengguna');
        });
    });
});