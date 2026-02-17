<?php

use Illuminate\Support\Facades\Route;


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

// Pelanggaran
Route::get('/monitoring-pelanggaran', function () {
    return view('pages.monitoring-pelanggaran', [
        'type_menu' => 'pelanggaran'
    ]);
});



