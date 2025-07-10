<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasSaya = collect();
        $tugasBelumDikerjakan = collect();

        if ($user->hasRole('Murid') && $user->relationLoaded('siswa')
            ? $user->siswa : $user->load('siswa')->siswa
        ) {
            $siswa = $user->siswa;

            if ($siswa && $siswa->kelas_id) {
                // Kelas yang diikuti siswa
                $kelasSaya = Kelas::with(['waliKelas.user', 'siswa'])
                    ->where('id', $siswa->kelas_id)
                    ->get();

                // Tugas belum dikerjakan oleh siswa
                $tugasBelumDikerjakan = Tugas::where('kelas_id', $siswa->kelas_id)
                    ->with(['mataPelajaran', 'kelas']) // relasi benar
                    ->whereDoesntHave('jawaban', function ($q) use ($siswa) {
                        $q->where('siswa_id', $siswa->id);
                    })
                    ->orderByDesc('tanggal_deadline')
                    ->get();
            }
        }

        return view('dashboard', compact('kelasSaya', 'tugasBelumDikerjakan'));
    }
}
