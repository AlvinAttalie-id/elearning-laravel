<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Models\Siswa;
use App\Models\JawabanTugas;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class DetailNilaiSiswa extends Page
{

    protected static ?string $title = 'Detail Nilai Siswa';
    protected static string $view = 'filament.resources.kelas-resource.pages.detail-nilai-siswa';

    public Siswa $siswa;

    public array $jawaban = [];
    public int $jumlahTugas = 0;
    public int $totalNilai = 0;
    public float $rataNilai = 0;
    public string $nilaiHurufAkhir = '-';
    public array $rataNilaiPerMapel = [];
    public array $nilaiHurufPerMapel = [];

    public function mount(Siswa $siswa): void
    {
        $this->siswa = $siswa->load(['user', 'kelas']);

        // Ambil semua jawaban tugas
        $jawabanTugas = JawabanTugas::with(['tugas.mataPelajaran', 'nilai'])
            ->where('siswa_id', $siswa->id)
            ->get();

        $grouped = $jawabanTugas->groupBy(fn($item) => $item->tugas->mataPelajaran->nama_mapel ?? 'Tanpa Mata Pelajaran');

        $this->jawaban = $grouped->toArray();

        // Hitung total dan rata-rata
        $nilaiAll = $jawabanTugas->pluck('nilai.nilai')->filter();

        $this->jumlahTugas = $nilaiAll->count();
        $this->totalNilai = $nilaiAll->sum();
        $this->rataNilai = $nilaiAll->count() ? round($nilaiAll->avg(), 1) : 0;
        $this->nilaiHurufAkhir = $this->konversiNilaiHuruf($this->rataNilai);

        // Rata-rata per mapel
        foreach ($grouped as $mapel => $list) {
            $nilaiMapel = collect($list)->pluck('nilai.nilai')->filter();
            $avg = $nilaiMapel->count() ? round($nilaiMapel->avg(), 1) : 0;
            $this->rataNilaiPerMapel[$mapel] = $avg;
            $this->nilaiHurufPerMapel[$mapel] = $this->konversiNilaiHuruf($avg);
        }
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export Nilai PDF')
                ->icon('heroicon-o-printer')
                ->color('warning')
                ->action(function () {
                    $pdf = Pdf::loadView('exports.detail-nilai-siswa', [
                        'siswa' => $this->siswa,
                        'jawaban' => $this->jawaban,
                        'jumlahTugas' => $this->jumlahTugas,
                        'totalNilai' => $this->totalNilai,
                        'rataNilai' => $this->rataNilai,
                        'nilaiHurufAkhir' => $this->nilaiHurufAkhir,
                        'rataNilaiPerMapel' => $this->rataNilaiPerMapel,
                        'nilaiHurufPerMapel' => $this->nilaiHurufPerMapel,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->stream()),
                        'detail_nilai_' . str($this->siswa->user->name)->slug() . '.pdf'
                    );
                }),
        ];
    }

    protected function konversiNilaiHuruf(float $nilai): string
    {
        return match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default => 'E',
        };
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
