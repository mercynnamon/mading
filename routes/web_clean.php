<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KomentarController;

// Root redirect
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect()->route('login');
        }
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Quick login routes for testing
Route::get('/login-admin', function () {
    $user = \App\Models\User::where('username', 'admin')->first();
    \Auth::login($user);
    return redirect()->route('admin.dashboard');
});

Route::get('/login-guru', function () {
    $user = \App\Models\User::where('username', 'guru')->first();
    \Auth::login($user);
    return redirect()->route('guru.dashboard');
});

Route::get('/login-siswa', function () {
    $user = \App\Models\User::where('username', 'siswa')->first();
    \Auth::login($user);
    return redirect()->route('siswa.dashboard');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/artikel/{id}/approve', [AdminController::class, 'approveArtikel'])->name('artikel.approve');
        Route::post('/artikel/{id}/reject', [AdminController::class, 'rejectArtikel'])->name('artikel.reject');
        Route::post('/kategori/store', [AdminController::class, 'storeKategori'])->name('kategori.store');
    });

    // Guru Routes
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
        Route::get('/artikel-saya', [GuruController::class, 'artikelSaya'])->name('artikel-saya');
        Route::get('/artikel-pending', [GuruController::class, 'artikelPending'])->name('artikel-pending');
        Route::post('/artikel/{id}/approve', [GuruController::class, 'approveArtikel'])->name('artikel.approve');
        Route::post('/artikel/{id}/reject', [GuruController::class, 'rejectArtikel'])->name('artikel.reject');
    });

    // Siswa Routes
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/artikel-saya', [SiswaController::class, 'artikelSaya'])->name('artikel-saya');
        Route::get('/artikel-disukai', [SiswaController::class, 'artikelDisukai'])->name('artikel-disukai');
        Route::post('/like/{id}', [SiswaController::class, 'likeArtikel'])->name('like');
    });

    // Artikel Routes
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel/store', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.detail');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.delete');

    // Komentar Routes
    Route::post('/artikel/{id}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
});