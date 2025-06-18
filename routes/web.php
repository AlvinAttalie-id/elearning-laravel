<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;
use App\Filament\Resources\KelasResource\Pages\SiswaKelas;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TugasController;

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
        Route::post('/kelas/{id}/join', [KelasController::class, 'join'])->name('kelas.join')->middleware('auth');

        Route::get('/kelas-saya/{id}', [KelasController::class, 'showSaya'])->name('kelas.show-saya');
        Route::get('/kelas-saya', [KelasController::class, 'indexKelasSaya'])->name('kelas.saya');
        Route::delete('/kelas/{id}/keluar', [KelasController::class, 'keluar'])->name('kelas.keluar')->middleware(['auth', 'role:Murid']);

        Route::get('/kelas/{kelas}/mapel/{mapel}/tugas', [TugasController::class, 'indexByKelasMapel'])
            ->name('tugas.kelas-mapel')
            ->middleware(['auth']);
        Route::get('/kelas/{kelas}/mapel/{mapel}/tugas/{tugas}', [TugasController::class, 'show'])
            ->middleware(['auth'])->name('tugas.show');
        Route::post('/tugas/{tugas}/jawab', [TugasController::class, 'jawab'])->name('tugas.jawab');
        Route::post('/tugas/{id}/jawab', [TugasController::class, 'jawab'])->name('tugas.jawab');
    });
});

require __DIR__ . '/auth.php';
