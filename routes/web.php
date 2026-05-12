<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


// Rute khusus untuk Pelapor (Mahasiswa & Dosen)
Route::middleware(['auth', 'role:mahasiswa,dosen'])->group(function () {
    Route::get('/dashboard', [ComplaintController::class, 'index'])->name('dashboard');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
});

// Rute khusus untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
});

require __DIR__.'/auth.php';
