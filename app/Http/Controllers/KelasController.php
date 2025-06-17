<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua kelas
        $daftarKelas = Kelas::with(['waliKelas.user', 'mataPelajaran', 'siswa'])->get();

        // Filter: hanya tampilkan kelas yang belum diikuti user
        $kelasBelumJoin = $daftarKelas->reject(function ($kelas) use ($user) {
            return $kelas->siswa->contains('user_id', $user->id);
        });

        return view('kelas.index', compact('kelasBelumJoin'));
    }

    public function show($id)
    {
        $kelas = Kelas::with(['waliKelas.user', 'siswa', 'mataPelajaran'])->findOrFail($id);
        return view('kelas.show', compact('kelas'));
    }
}
