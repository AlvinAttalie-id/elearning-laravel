<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\RegisterGuruController;
use App\Filament\Resources\KelasResource\Pages\SiswaKelas;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    KelasController,
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

    Route::middleware(RoleMiddleware::class . ':Guru')->group(function () {});
});

require __DIR__ . '/auth.php';
