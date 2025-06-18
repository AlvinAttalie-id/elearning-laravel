<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function indexByKelasMapel($kelasId, $mapelId)
    {
        $user = Auth::user();

        // Pastikan user adalah siswa dari kelas tersebut
        $siswa = $user->siswa;
        if (!$siswa || $siswa->kelas_id != $kelasId) {
            abort(403, 'Anda tidak memiliki akses ke tugas kelas ini.');
        }

        $kelas = Kelas::findOrFail($kelasId);
        $mapel = \App\Models\MataPelajaran::findOrFail($mapelId);

        // Ambil semua tugas yang sesuai
        $tugas = \App\Models\Tugas::where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->orderByDesc('tanggal_deadline')
            ->get();

        return view('tugas.index', compact('kelas', 'mapel', 'tugas'));
    }

    public function show($kelasId, $mapelId, $tugasId)
    {
        $tugas = Tugas::with('mapel', 'kelas')->findOrFail($tugasId);
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa || $siswa->kelas_id != $kelasId) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Ambil jawaban tugas siswa ini jika ada
        $jawaban = JawabanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        // Ambil nilai jika jawaban ada
        $nilai = $jawaban?->nilai;

        return view('tugas.show', compact('tugas', 'siswa', 'jawaban', 'nilai'));
    }

    public function jawab(Request $request, $tugasId)
    {
        $request->validate([
            'jawaban' => 'nullable|string',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        $tugas = Tugas::findOrFail($tugasId);

        // Cegah jika bukan dari kelas yang sesuai
        if (!$siswa || $siswa->kelas_id !== $tugas->kelas_id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek jika sudah pernah menjawab
        $existing = JawabanTugas::where('tugas_id', $tugasId)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah menjawab tugas ini.');
        }

        $jawaban = new JawabanTugas();
        $jawaban->tugas_id = $tugasId;
        $jawaban->siswa_id = $siswa->id;
        $jawaban->jawaban = $request->jawaban;
        $jawaban->submitted_at = Carbon::now();

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = $file->store('jawaban_tugas', 'public');
            $jawaban->file_path = $filename;
        }

        $jawaban->save();

        return redirect()->route('tugas.kelas-mapel', ['kelas' => $tugas->kelas_id, 'mapel' => $tugas->mapel_id])
            ->with('success', 'Jawaban berhasil dikirim.');
    }

    public function belumDikerjakan()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            abort(403, 'Akses hanya untuk murid.');
        }

        // Ambil semua tugas yang belum dijawab oleh siswa
        $tugasBelum = Tugas::where('kelas_id', $siswa->kelas_id)
            ->whereDoesntHave('jawaban', function ($query) use ($siswa) {
                $query->where('siswa_id', $siswa->id);
            })
            ->with(['mapel', 'kelas'])
            ->orderByDesc('tanggal_deadline')
            ->get();

        return view('tugas.belum', compact('tugasBelum'));
    }
}
