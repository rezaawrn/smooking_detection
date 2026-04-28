<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PelanggaranController;

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


