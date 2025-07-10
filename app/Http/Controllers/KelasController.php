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

        $daftarKelas = Kelas::withCount('siswa')
            ->with(['waliKelas.user', 'mataPelajaran'])
            ->get();

        $kelasSaya = $user->siswa->kelas_id ?? null;

        $kelasBelumJoin = $daftarKelas->reject(function ($kelas) use ($user) {
            return $kelas->siswa->contains('user_id', $user->id);
        });

        return view('kelas.index', compact('kelasBelumJoin', 'kelasSaya'));
    }

    public function show(Kelas $kelas)
    {
        $user = Auth::user();

        $kelas->loadCount('siswa')
            ->load(['waliKelas.user', 'mataPelajaran']);

        $siswa = $user->siswa;
        $kelasSayaId = $siswa?->kelas_id;

        $kelasPenuh = $kelas->siswa_count >= $kelas->maksimal_siswa;

        return view('kelas.show', [
            'kelas' => $kelas,
            'sudahJoinKelasLain' => $kelasSayaId && $kelasSayaId != $kelas->id,
            'sudahJoinKelasIni' => $kelasSayaId == $kelas->id,
            'kelasPenuh' => $kelasPenuh,
        ]);
    }

    public function join(Kelas $kelas, Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->back()->with('error', 'Akun Anda belum terdaftar sebagai siswa.');
        }

        if ($kelas->siswa()->count() >= $kelas->maksimal_siswa) {
            return redirect()->back()->with('error', 'Kelas ini sudah penuh.');
        }

        $siswa->kelas_id = $kelas->id;
        $siswa->save();

        return redirect()->route('kelas.show', $kelas)->with('success', 'Berhasil bergabung ke kelas.');
    }

    public function keluar(Kelas $kelas)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa || $siswa->kelas_id != $kelas->id) {
            return redirect()->back()->with('error', 'Anda tidak tergabung di kelas ini.');
        }

        $siswa->kelas_id = null;
        $siswa->save();

        return redirect()->route('kelas.saya')->with('success', 'Anda telah keluar dari kelas.');
    }

    public function indexKelasSaya()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            abort(403, 'Akses hanya untuk siswa.');
        }

        $kelasSaya = $siswa->kelas()->with([
            'waliKelas.user',
            'mataPelajaran.tugas'
        ])->get();

        return view('kelas.index-saya', compact('kelasSaya'));
    }

    public function showSaya(Kelas $kelas)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Validasi akses
        if (!$siswa || $siswa->kelas_id != $kelas->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $kelas->loadCount('siswa')
            ->load([
                'waliKelas.user',
                'mataPelajaran.guru.user',
                'mataPelajaran.tugas.jawaban',
            ]);

        $totalTugasBelum = 0;

        // Format data mapel
        $mapelList = $kelas->mataPelajaran->map(function ($mapel) use ($siswa, &$totalTugasBelum) {
            $jumlahTugasBelum = $mapel->tugas->filter(function ($tugas) use ($siswa) {
                return $tugas->jawaban->where('siswa_id', $siswa->id)->isEmpty();
            })->count();

            $totalTugasBelum += $jumlahTugasBelum;

            return (object)[
                'id' => $mapel->id,
                'slug' => $mapel->slug,
                'nama' => $mapel->nama_mapel,
                'guru_name' => $mapel->guru?->user?->name ?? '-',
                'jumlah_tugas' => $mapel->tugas->count(),
                'jumlah_tugas_belum' => $jumlahTugasBelum,
            ];
        });

        return view('kelas.show-saya', [
            'kelas' => $kelas,
            'mapelList' => $mapelList,
            'totalTugasBelum' => $totalTugasBelum,
        ]);
    }
}
