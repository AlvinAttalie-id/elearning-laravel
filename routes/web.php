<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;
use App\Filament\Resources\KelasResource\Pages\SiswaKelas;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;

// Halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Filament - akses siswa kelas (gunakan middleware sesuai kebutuhan)
Route::get('/admin/kelas/{kelas}/siswa', SiswaKelas::class)
    ->middleware(['auth']) // tambahkan middleware 'role:Admin' jika hanya admin
    ->name('filament.admin.resources.kelas.siswa');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile (semua user yang login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Ganti 'role:Murid' dengan kelas middleware
    Route::middleware([RoleMiddleware::class . ':Murid'])->group(function () {
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/{id}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/kelas-saya', [KelasController::class, 'kelasSaya'])->name('kelas.saya');
    });
});

require __DIR__ . '/auth.php';
