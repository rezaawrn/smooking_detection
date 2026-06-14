<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/auth-login');

// Login
Route::get('/auth-login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth-login', [AuthController::class, 'login']);

// Route yang harus login
Route::middleware('auth')->group(function () {

    // Monitoring kamera
    Route::get('/monitoring-kamera', function () {
        return view('pages.monitoring-kamera', [
            'type_menu' => 'kamera'
        ]);
    });

    // Monitoring pelanggaran
    Route::get('/monitoring-pelanggaran', [PelanggaranController::class, 'index']);

    // Hapus data pelanggaran
    Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy']);

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // API untuk mendapatkan data deteksi terbaru
    Route::get('/api/latest-detection', function () {
        $latest = DB::table('pelanggarans')
            ->latest('id')
            ->first();

        return response()->json([
            'id' => $latest->id ?? 0
        ]);
    });
});

// save foto pelanggaran
// tetap di luar auth karena dipanggil Raspberry Pi
Route::post('/save-detection', [PelanggaranController::class, 'store']);