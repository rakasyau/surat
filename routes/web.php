<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;

Route::get('/', [AppController::class, 'index'])->name('home');
Route::post('/check-name', [AppController::class, 'checkName'])->name('check.name');

// Halaman Cerita (Isi Pesan)
Route::get('/story', [AppController::class, 'story'])->name('story');

// Halaman Pilihan (Game Tombol)
Route::get('/choice', [AppController::class, 'choice'])->name('choice');

// Proses Simpan Jawaban
Route::post('/save-decision', [AppController::class, 'saveDecision'])->name('save.decision');

// Halaman Akhir
Route::get('/ending', [AppController::class, 'ending'])->name('ending');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.auth');
    
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});