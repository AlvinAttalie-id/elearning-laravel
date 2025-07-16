<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $kelasSaya = collect();
        $tugasBelumDikerjakan = collect();
        $kelasWali = null; // Tambahan ini

        // Jika murid
        if ($user->hasRole('Murid') && $user->relationLoaded('siswa') ? $user->siswa : $user->load('siswa')->siswa) {
            $siswa = $user->siswa;

            if ($siswa && $siswa->kelas_id) {
                $kelasSaya = Kelas::with(['waliKelas.user', 'siswa'])
                    ->where('id', $siswa->kelas_id)
                    ->get();

                $tugasBelumDikerjakan = Tugas::where('kelas_id', $siswa->kelas_id)
                    ->with(['mataPelajaran', 'kelas'])
                    ->whereDoesntHave('jawaban', function ($q) use ($siswa) {
                        $q->where('siswa_id', $siswa->id);
                    })
                    ->orderByDesc('tanggal_deadline')
                    ->get();
            }
        }

        // Jika guru dan merupakan wali kelas
        if ($user->hasRole('Guru') && $user->guru) {
            $kelasWali = Kelas::with(['siswa.user', 'mataPelajaran']) // ambil murid dan mapel
                ->where('wali_kelas_id', $user->guru->id)
                ->first();
        }

        return view('dashboard', compact('kelasSaya', 'tugasBelumDikerjakan', 'kelasWali'));
    }
}
