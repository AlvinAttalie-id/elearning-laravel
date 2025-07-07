<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\RegisterGuruController;
use App\Filament\Resources\KelasResource\Pages\SiswaKelas;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    KelasController,
    MataPelajaranController,
    TugasController,
};

Route::view('/', 'welcome');
Route::get('/register/pengajar', [RegisterGuruController::class, 'create'])->name('register.guru');
Route::post('/register/pengajar', [RegisterGuruController::class, 'store'])->name('register.guru.store');

Route::middleware('auth')
    ->get('/admin/kelas/{kelas}/siswa', SiswaKelas::class)
    ->name('filament.admin.resources.kelas.siswa');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/',    [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/',  [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware(RoleMiddleware::class . ':Murid')->group(function () {

        Route::prefix('kelas')->group(function () {
            Route::get('/',               [KelasController::class, 'index'])->name('kelas.index');
            Route::post('{kelas}/join',   [KelasController::class, 'join'])->name('kelas.join');
            Route::delete('{kelas}/keluar', [KelasController::class, 'keluar'])->name('kelas.keluar');
            Route::get('{kelas}',         [KelasController::class, 'show'])->name('kelas.show');
        });

        Route::prefix('kelas-saya')->group(function () {
            Route::get('/',        [KelasController::class, 'indexKelasSaya'])->name('kelas.saya');
            Route::get('{kelas}',  [KelasController::class, 'showSaya'])->name('kelas.show-saya');
        });

        Route::prefix('tugas')->group(function () {
            Route::post('{tugas}/jawab', [TugasController::class, 'jawab'])->name('tugas.jawab');
            Route::get('/tugas-belum', [TugasController::class, 'belumDikerjakan'])->name('tugas.belum');
        });

        Route::get(
            'kelas/{kelas}/mapel/{mapel}/tugas',
            [TugasController::class, 'indexByKelasMapel']
        )->name('tugas.kelas-mapel');

        Route::get(
            'kelas/{kelas}/mapel/{mapel}/tugas/{tugas}',
            [TugasController::class, 'show']
        )->name('tugas.show');
    });

    Route::middleware(RoleMiddleware::class . ':Guru')->group(function () {
        Route::prefix('guru')->group(function () {
            Route::get('/pilih-mapel',  [MataPelajaranController::class, 'index'])->name('guru.pilih-mapel');
            Route::post('/pilih-mapel', [MataPelajaranController::class, 'store'])->name('guru.simpan-mapel');

            Route::get('/mapel/{mapel}/kelas', [MataPelajaranController::class, 'kelasList'])->name('guru.mapel.kelas');

            Route::get('/mapel/{mapel}/kelas/{kelas}/tugas/create', [TugasController::class, 'create'])->name('guru.tugas.create');
            Route::post('/mapel/{mapel}/kelas/{kelas}/tugas', [TugasController::class, 'store'])->name('guru.tugas.store');

            Route::get('/mapel/{mapel}/kelas/{kelas}/tugas/{tugas}', [TugasController::class, 'detail'])
                ->name('guru.tugas.detail');
            Route::post('/jawaban/{jawaban}/nilai', [TugasController::class, 'beriNilai'])->name('guru.tugas.nilai');
        });
    });
});

require __DIR__ . '/auth.php';
