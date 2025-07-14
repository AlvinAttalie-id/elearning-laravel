<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function detailNilaiSiswa(Siswa $siswa)
    {
        $user = Auth::user();

        if (!$user->guru || $user->guru->id !== $siswa->kelas->wali_kelas_id) {
            abort(403, 'Anda bukan wali kelas dari siswa ini.');
        }

        $jawaban = JawabanTugas::with(['tugas.mataPelajaran', 'nilai'])
            ->where('siswa_id', $siswa->id)
            ->get()
            ->groupBy(fn($j) => $j->tugas->mataPelajaran->nama_mapel ?? 'Tanpa Mapel');

        $jumlahTugas = $jawaban->flatten()->count();

        $totalNilai = $jawaban->flatten()
            ->filter(fn($j) => $j->nilai)
            ->sum(fn($j) => $j->nilai->nilai);

        $rataNilai = $jumlahTugas ? $totalNilai / $jumlahTugas : 0;
        $nilaiHurufAkhir = $this->konversiNilaiKeHuruf($rataNilai);

        // Hitung rata-rata per mapel dan nilai hurufnya
        $rataNilaiPerMapel = [];
        $nilaiHurufPerMapel = [];

        foreach ($jawaban as $mapel => $jawabanMapel) {
            $jumlahTugasMapel = $jawabanMapel->count();
            $totalNilaiMapel = $jawabanMapel->filter(fn($j) => $j->nilai)
                ->sum(fn($j) => $j->nilai->nilai);

            $rata = $jumlahTugasMapel ? $totalNilaiMapel / $jumlahTugasMapel : 0;

            $rataNilaiPerMapel[$mapel] = number_format($rata, 1);
            $nilaiHurufPerMapel[$mapel] = $this->konversiNilaiKeHuruf($rata);
        }

        return view('guru.kelas.detail-nilai', compact(
            'siswa',
            'jawaban',
            'jumlahTugas',
            'totalNilai',
            'rataNilai',
            'nilaiHurufAkhir',
            'rataNilaiPerMapel',
            'nilaiHurufPerMapel'
        ));
    }

    private function konversiNilaiKeHuruf($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 85) return 'B';
        if ($nilai >= 80) return 'C';
        if ($nilai >= 75) return 'D';
        return 'E';
    }
}
