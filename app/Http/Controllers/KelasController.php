<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filterJenjang = $request->query('jenjang');

        $query = Kelas::withCount('siswa')
            ->with(['waliKelas.user', 'mataPelajaran']);

        if ($filterJenjang) {
            $query->where('nama', 'like', "{$filterJenjang}-%");
        }

        $daftarKelas = $query->orderBy('nama')->paginate(5)->withQueryString();
        $kelasSaya = $user->siswa->kelas_id ?? null;

        // Filter kelas yang belum diikuti user
        $kelasBelumJoin = $daftarKelas->filter(function ($kelas) use ($user) {
            return !$kelas->siswa->contains('user_id', $user->id);
        });

        return view('kelas.index', compact('daftarKelas', 'kelasSaya', 'kelasBelumJoin', 'filterJenjang'));
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
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return back()->with('error', 'Akun Anda belum terdaftar sebagai siswa.');
        }

        if ($kelas->siswa()->count() >= $kelas->maksimal_siswa) {
            return back()->with('error', 'Kelas ini sudah penuh.');
        }

        $siswa->kelas_id = $kelas->id;
        $siswa->save();

        return redirect()->route('kelas.show', $kelas->slug)->with('success', 'Berhasil bergabung ke kelas.');
    }

    public function keluar(Kelas $kelas)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa || $siswa->kelas_id != $kelas->id) {
            return back()->with('error', 'Anda tidak tergabung di kelas ini.');
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
            'mataPelajaran.tugas',
        ])->get();

        return view('kelas.index-saya', compact('kelasSaya'));
    }

    public function showSaya(Kelas $kelas)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

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

    public function detailWali(Kelas $kelas, Request $request)
    {
        $user = Auth::user();

        // Cek apakah user adalah wali kelas dari kelas tersebut
        if (!$user->guru || $user->guru->id !== $kelas->wali_kelas_id) {
            abort(403, 'Anda bukan wali kelas dari kelas ini.');
        }

        $kelas->load(['mataPelajaran.guru.user', 'waliKelas.user']);

        // Ambil siswa dengan user-nya (untuk nama) dan paginate
        $siswaList = $kelas->siswa()->with('user')->paginate(10);

        return view('guru.kelas.detail-wali', compact('kelas', 'siswaList'));
    }

    public function indexWaliKelas()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            abort(403, 'Akun ini bukan guru.');
        }

        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();

        if (!$kelas) {
            // Tampilkan view kosong dengan pesan
            return view('guru.kelas.wali-kelas', [
                'kelas' => null,
                'bukanWali' => true,
            ]);
        }

        return view('guru.kelas.wali-kelas', [
            'kelas' => $kelas,
            'bukanWali' => false,
        ]);
    }
}
