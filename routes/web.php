<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenilaianSiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'landingPage'])->middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::get('tes', function () {
    $data = Auth::user()->siswa;
    return response()->json($data);
})->middleware('auth');

Route::post('/signin', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/signup', [RegisterController::class, 'index'])->name('signup');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Middleware auth untuk semua route yang membutuhkan login
Route::middleware('auth')->group(function () {
    
    // Dashboard - bisa diakses semua role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Siswa - hanya untuk admin (validasi di controller)
    Route::get('/data_siswa', [DataSiswaController::class, 'index'])->name('data_siswa');
    Route::post('/siswa_store', [DataSiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa_edit-{id}', [DataSiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa_update/{id}', [DataSiswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa_delete/{id}', [DataSiswaController::class, 'destroy']);

    // Penilaian - untuk admin, guru_bk, guru (validasi di controller)
    Route::get('/penilaian_siswa', [PenilaianSiswaController::class, 'index'])->name('penilaian_siswa');
    Route::post('/store_penilaian', [PenilaianSiswaController::class, 'store'])->name('penilaian.store');
    Route::get('/penilaian_delete/{id}', [PenilaianSiswaController::class, 'destroy']);

    // Laporan - bisa diakses semua role (validasi di controller)
    Route::get('/laporan_siswa', [LaporanSiswaController::class, 'index'])->name('laporan_siswa');
    Route::get('/laporan_pdf', [LaporanSiswaController::class, 'pdf'])->name('laporan_pdf');
    Route::get('/laporan_pdf_download', [LaporanSiswaController::class, 'pdfDownload'])->name('laporan_pdf_download');

    // Users Management - hanya untuk admin (validasi di controller)
    Route::resource('users', UserController::class);
});

Route::get('/non_admin', function () {
    return view('non_admin');
});