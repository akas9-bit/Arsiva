<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// HALAMAN AWAL
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('beranda');
    }

    return redirect()->route('login');
});

// LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');
});

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// HALAMAN PENGGUNA LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/beranda', [PengajuanController::class, 'beranda'])
        ->name('beranda');

    Route::get('/pengajuan/buat', [PengajuanController::class, 'create'])
        ->name('pengajuan.create');

    Route::post('/pengajuan', [PengajuanController::class, 'store'])
        ->name('pengajuan.store');

    Route::get('/pengajuan/riwayat', [PengajuanController::class, 'riwayat'])
        ->name('pengajuan.riwayat');

    Route::get('/pengajuan/{pengajuan}/berkas', [PengajuanController::class, 'berkas'])
        ->name('pengajuan.berkas');

    Route::get('/pengajuan/{pengajuan}/hasil', [PengajuanController::class, 'hasil'])
        ->name('pengajuan.hasil');

    // PROFIL
    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profil');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profil.update');

    // GANTI PASSWORD
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
        ->name('profil.password.update');
});

// HALAMAN ADMIN
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/siswa', [SiswaController::class, 'index'])
            ->name('siswa.index');

        Route::get('/siswa/tambah', [SiswaController::class, 'create'])
            ->name('siswa.create');

        Route::post('/siswa', [SiswaController::class, 'store'])
            ->name('siswa.store');

        Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])
            ->name('siswa.edit');

        Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])
            ->name('siswa.update');

        Route::patch('/siswa/{siswa}/status-ijazah', [SiswaController::class, 'updateStatus'])
            ->name('siswa.updateStatus');

        Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])
            ->name('siswa.destroy');

        Route::patch('/pengajuan/{id}/update-status', [DashboardController::class, 'updateStatus'])
            ->name('pengajuan.updateStatus');

        Route::delete('/pengajuan/{pengajuan}', [DashboardController::class, 'destroy'])
            ->name('pengajuan.destroy');
    });