<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\RegisterGuruController;
use App\Filament\Resources\KelasResource\Pages\SiswaKelas;
use App\Http\Controllers\{
    DashboardController,
    GuruController,
    ProfileController,
    KelasController,
    MataPelajaranController,
    TugasController,
};

Route::view('/', 'welcome');

// Pendaftaran Guru
Route::get('/register/pengajar', [RegisterGuruController::class, 'create'])->name('register.guru');
Route::post('/register/pengajar', [RegisterGuruController::class, 'store'])->name('register.guru.store');

// Filament
Route::middleware('auth')
    ->get('/admin/kelas/{kelas}/siswa', SiswaKelas::class)
    ->name('filament.admin.resources.kelas.siswa');

// Route setelah login & verifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/',    [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/',  [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Murid
    Route::middleware(RoleMiddleware::class . ':Murid')->group(function () {

        // Kelas
        Route::prefix('kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
            Route::post('{kelas:slug}/join', [KelasController::class, 'join'])->name('kelas.join');
            Route::delete('{kelas:slug}/keluar', [KelasController::class, 'keluar'])->name('kelas.keluar');
            Route::get('{kelas:slug}', [KelasController::class, 'show'])->name('kelas.show');
        });

        // Kelas yang diikuti murid
        Route::prefix('kelas-saya')->group(function () {
            Route::get('/', [KelasController::class, 'indexKelasSaya'])->name('kelas.saya');
            Route::get('{kelas:slug}', [KelasController::class, 'showSaya'])->name('kelas.show-saya');
        });

        // Tugas
        Route::prefix('tugas')->group(function () {
            Route::post('{tugas}/jawab', [TugasController::class, 'jawab'])->name('tugas.jawab');
            Route::get('/belum', [TugasController::class, 'belumDikerjakan'])->name('tugas.belum');
        });

        // Lihat daftar tugas berdasarkan mapel dan kelas
        Route::get(
            'mapel/{mataPelajaran:slug}/kelas/{kelas:slug}/tugas',
            [TugasController::class, 'indexByKelasMapel']
        )->name('tugas.kelas-mapel');

        // Lihat detail tugas (untuk menjawab)
        Route::get(
            'mapel/{mataPelajaran:slug}/kelas/{kelas:slug}/tugas/{tugas:slug}',
            [TugasController::class, 'show']
        )->name('tugas.show');
    });

    // Guru
    Route::middleware(RoleMiddleware::class . ':Guru')->group(function () {
        Route::prefix('guru')->group(function () {

            // Pilih Mapel
            Route::get('/pilih-mapel', [MataPelajaranController::class, 'index'])->name('guru.pilih-mapel');
            Route::post('/pilih-mapel', [MataPelajaranController::class, 'store'])->name('guru.simpan-mapel');

            // Daftar Kelas berdasarkan Mapel
            Route::get('/wali-kelas', [KelasController::class, 'indexWaliKelas'])->name('guru.kelas.wali-kelas');
            Route::get('/mapel/{mataPelajaran:slug}/kelas', [MataPelajaranController::class, 'kelasList'])->name('guru.mapel.kelas');
            Route::get('/kelas/detail-wali/{kelas:slug}', [KelasController::class, 'detailWali'])->name('guru.kelas.detail-wali');
            Route::get('/siswa/{siswa}/detail-nilai', [GuruController::class, 'detailNilaiSiswa'])->name('guru.kelas.detail-nilai');

            // Tugas Guru
            Route::get('/mapel/{mataPelajaran:slug}/kelas/{kelas:slug}/tugas/create', [TugasController::class, 'create'])->name('guru.tugas.create');
            Route::post('/mapel/{mataPelajaran:slug}/kelas/{kelas:slug}/tugas', [TugasController::class, 'store'])->name('guru.tugas.store');
            Route::get('/mapel/{mataPelajaran:slug}/kelas/{kelas:slug}/tugas/{tugas:slug}', [TugasController::class, 'detail'])->name('guru.tugas.detail');

            // Penilaian
            Route::post('/jawaban/{jawaban}/nilai', [TugasController::class, 'beriNilai'])->name('guru.tugas.nilai');
        });
    });
});

require __DIR__ . '/auth.php';
