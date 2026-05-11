<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/monitoring-kamera');

// Login
Route::get('/auth-login', function () {
    return view('pages.auth-login', [
        'type_menu' => 'login'
    ]);
});

// Kamera
Route::get('/monitoring-kamera', function () {
    return view('pages.monitoring-kamera', ['type_menu' => 'kamera']);
});

// save foto pelanggaran
Route::post('/save-detection', [PelanggaranController::class, 'store']);

// tampilkan halaman monitoring pelanggaran
Route::get('/monitoring-pelanggaran', [PelanggaranController::class, 'index']);

// hapus data pelanggaran
Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy']);

// tampilkan form login
Route::get('/auth-login', [AuthController::class, 'showLogin'])->name('login');

// proses login
Route::post('/auth-login', [AuthController::class, 'login']);

// halaman setelah login
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// API untuk mendapatkan data deteksi terbaru
Route::get('/api/latest-detection', function(){

    $latest = DB::table('pelanggarans')
        ->latest('id')
        ->first();

    return response()->json([
        'id' => $latest->id ?? 0
    ]);

});