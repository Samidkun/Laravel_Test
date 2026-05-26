<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterLowonganController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BookController;

// Redirect home to the public job list (requires auth)
Route::redirect('/', '/lowongan');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public/Guest Routes (Authorized Users - Guest or Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/lowongan', [PendaftaranController::class, 'publicIndex'])->name('pendaftaran.index');
    Route::get('/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::get('/daftar/{lowonganId}', [PendaftaranController::class, 'create'])->name('pendaftaran.create_with_id');
    Route::post('/daftar/submit', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/status-pendaftaran', [PendaftaranController::class, 'myApplications'])->name('pendaftaran.my_status');
});

// Admin Routes (Restricted to Admin role only)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Vacancy CRUD
    Route::get('/lowongan', [MasterLowonganController::class, 'index'])->name('admin.lowongan.index');
    Route::get('/lowongan/create', [MasterLowonganController::class, 'create'])->name('admin.lowongan.create');
    Route::post('/lowongan/store', [MasterLowonganController::class, 'store'])->name('admin.lowongan.store');
    Route::get('/lowongan/{id}/edit', [MasterLowonganController::class, 'edit'])->name('admin.lowongan.edit');
    Route::put('/lowongan/{id}/update', [MasterLowonganController::class, 'update'])->name('admin.lowongan.update');
    Route::delete('/lowongan/{id}/delete', [MasterLowonganController::class, 'destroy'])->name('admin.lowongan.destroy');

    // Applicants Management
    Route::get('/pendaftar', [PendaftaranController::class, 'adminIndex'])->name('admin.pendaftar.index');
    Route::patch('/pendaftar/{id}/status', [PendaftaranController::class, 'updateStatus'])->name('admin.pendaftar.status');

    // Reports
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
});

// Retain Book routes just in case
Route::resource('books', BookController::class);
