<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenilaianSiswaController;
use App\Http\Controllers\RegisterController;
use App\Models\DataSiswa;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'landingPage'])->middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/signin', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/signup', [RegisterController::class, 'index'])->name('signup');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard')->middleware('auth');
Route::get('/data_siswa', [DataSiswaController::class,'index'])->name('data_siswa')->middleware('auth');
Route::post('/siswa_store', [DataSiswaController::class,'store'])->name('siswa.store')->middleware('auth');
Route::get('/siswa_edit-{id}', [DataSiswaController::class,'edit'])->name('siswa.edit')->middleware('auth');
Route::post('/siswa_update/{id}', [DataSiswaController::class,'update'])->name('siswa.update')->middleware('auth');
Route::get('/siswa_delete/{id}', [DataSiswaController::class,'destroy'])->middleware('auth');
Route::get('/penilaian_siswa', [PenilaianSiswaController::class,'index'])->name('penilaian_siswa')->middleware('auth');
Route::post('/store_penilaian', [PenilaianSiswaController::class,'store'])->name('penilaian.store')->middleware('auth');
Route::get('/penilaian_delete/{id}', [PenilaianSiswaController::class,'destroy'])->middleware('auth');
Route::get('/laporan_siswa', [LaporanSiswaController::class,'index'])->name('laporan_siswa')->middleware('auth');
Route::get('/laporan_pdf', [LaporanSiswaController::class,'pdf'])->name('laporan_pdf')->middleware('auth');
Route::get('/laporan_pdf_download', [LaporanSiswaController::class, 'pdfDownload'])->name('laporan_pdf_download')->middleware('auth');

Route::get('/non_admin', function () {
    return view('non_admin');
});
