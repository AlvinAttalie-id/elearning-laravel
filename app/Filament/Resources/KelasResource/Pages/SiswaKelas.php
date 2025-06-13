<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Models\Kelas;
use Filament\Pages\Page;

class SiswaKelas extends Page
{
    protected static ?string $title = 'Daftar Siswa';
    protected static string $view = 'filament.resources.kelas-resource.pages.siswa-kelas';

    public $kelas;
    public $siswa;

    public function mount($kelas): void
    {
        $this->kelas = Kelas::with(['siswa.user'])->findOrFail($kelas);
        $this->siswa = $this->kelas->siswa;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
