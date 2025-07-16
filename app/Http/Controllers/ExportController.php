<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\JawabanTugas;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function detailNilaiSiswa(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas']);

        // Ambil semua jawaban tugas
        $jawabanTugas = JawabanTugas::with(['tugas.mataPelajaran', 'nilai'])
            ->where('siswa_id', $siswa->id)
            ->get();

        $grouped = $jawabanTugas->groupBy(fn($item) => $item->tugas->mataPelajaran->nama_mapel ?? 'Tanpa Mata Pelajaran');

        // Hitung total dan rata-rata
        $nilaiAll = $jawabanTugas->pluck('nilai.nilai')->filter();

        $jumlahTugas = $nilaiAll->count();
        $totalNilai = $nilaiAll->sum();
        $rataNilai = $nilaiAll->count() ? round($nilaiAll->avg(), 1) : 0;
        $nilaiHurufAkhir = $this->konversiNilaiHuruf($rataNilai);

        // Rata-rata per mapel
        $rataNilaiPerMapel = [];
        $nilaiHurufPerMapel = [];

        foreach ($grouped as $mapel => $list) {
            $nilaiMapel = collect($list)->pluck('nilai.nilai')->filter();
            $avg = $nilaiMapel->count() ? round($nilaiMapel->avg(), 1) : 0;
            $rataNilaiPerMapel[$mapel] = $avg;
            $nilaiHurufPerMapel[$mapel] = $this->konversiNilaiHuruf($avg);
        }

        $pdf = Pdf::loadView('exports.detail-nilai-siswa', [
            'siswa' => $siswa,
            'jawaban' => $grouped,
            'jumlahTugas' => $jumlahTugas,
            'totalNilai' => $totalNilai,
            'rataNilai' => $rataNilai,
            'nilaiHurufAkhir' => $nilaiHurufAkhir,
            'rataNilaiPerMapel' => $rataNilaiPerMapel,
            'nilaiHurufPerMapel' => $nilaiHurufPerMapel,
        ]);

        return $pdf->download('detail_nilai_' . str($siswa->user->name)->slug() . '.pdf');
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
}
