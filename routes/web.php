<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Redirect root to welcome
Route::redirect('/', '/welcome');

// Welcome route
Route::get('/welcome', function () {
    return view('welcome');
});

// Admin Routes Group with Prefix 'admin'
Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('admin.dashboard', ['type_menu' => 'dashboard']);
    });

    // Data Lulusan route
    Route::get('/data-lulusan', function () {
        return view('admin.data-lulusan', ['type_menu' => 'lulusan']);
    });

    // Generate Link Lulusan route
    Route::get('/generate-link-lulusan', function () {
        return view('admin.generate-link-lulusan', ['type_menu' => 'lulusan']);
    });
});

// Auth Routes
Route::get('/auth/login', function () {
    return view('auth.login-page');
});
