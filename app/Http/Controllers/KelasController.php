<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua kelas
        $daftarKelas = Kelas::with(['waliKelas.user', 'mataPelajaran', 'siswa'])->get();

        // Ambil kelas yang sedang diikuti user (jika user adalah murid)
        $kelasSaya = $user->siswa->kelas_id ?? null;

        // Filter hanya kelas yang belum diikuti (opsional, jika kamu tetap ingin)
        $kelasBelumJoin = $daftarKelas->reject(function ($kelas) use ($user) {
            return $kelas->siswa->contains('user_id', $user->id);
        });

        return view('kelas.index', compact('kelasBelumJoin', 'kelasSaya'));
    }



    public function show($id)
    {
        $user = Auth::user();
        $kelas = Kelas::with(['waliKelas.user', 'mataPelajaran', 'siswa'])->findOrFail($id);

        $siswa = $user->siswa;
        $kelasSayaId = $siswa?->kelas_id;

        return view('kelas.show', [
            'kelas' => $kelas,
            'sudahJoinKelasLain' => $kelasSayaId && $kelasSayaId != $kelas->id,
            'sudahJoinKelasIni' => $kelasSayaId == $kelas->id,
        ]);
    }

    public function join($id, Request $request)
    {
        $user = Auth::user();

        // Pastikan user memiliki data siswa
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->back()->with('error', 'Akun Anda belum terdaftar sebagai siswa.');
        }

        // Update kelas_id pada siswa
        $siswa->kelas_id = $id;
        $siswa->save();

        return redirect()->route('kelas.show', $id)->with('success', 'Berhasil bergabung ke kelas.');
    }

    public function showSaya($id)
    {
        $kelas = Kelas::with(['waliKelas.user', 'mataPelajaran', 'siswa'])->findOrFail($id);

        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Cek apakah user merupakan siswa di kelas ini
        $isAnggotaKelas = $kelas->siswa->pluck('user_id')->contains($userId);

        if (! $isAnggotaKelas) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        return view('kelas.show-saya', compact('kelas'));
    }

    public function indexKelasSaya()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Validasi jika user bukan siswa
        if (! $siswa) {
            abort(403, 'Akses hanya untuk siswa.');
        }

        // Ambil kelas yang diikuti oleh siswa (jika sudah punya kelas)
        $kelasSaya = $siswa->kelas()->with(['waliKelas.user', 'mataPelajaran'])->get();

        return view('kelas.index-saya', compact('kelasSaya'));
    }

    public function keluar($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa || $siswa->kelas_id != $id) {
            return redirect()->back()->with('error', 'Anda tidak tergabung di kelas ini.');
        }

        $siswa->kelas_id = null;
        $siswa->save();

        return redirect()->route('kelas.saya')->with('success', 'Anda telah keluar dari kelas.');
    }
}
