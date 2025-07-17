<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TugasFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // ====================== MURID SECTION ======================

    public function indexByKelasMapel(MataPelajaran $mataPelajaran, Kelas $kelas)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa || $siswa->kelas_id != $kelas->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas kelas ini.');
        }

        $tugas = Tugas::with(['mataPelajaran', 'kelas', 'jawaban'])
            ->where('mapel_id', $mataPelajaran->id)
            ->where('kelas_id', $kelas->id)
            ->orderByDesc('versi')
            ->orderByDesc('tanggal_deadline')
            ->with('jawaban')
            ->get();

        return view('tugas.index', [
            'kelas' => $kelas,
            'mataPelajaran' => $mataPelajaran,
            'tugas' => $tugas,
        ]);
    }

    public function show(MataPelajaran $mataPelajaran, Kelas $kelas, Tugas $tugas)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa || $siswa->kelas_id != $kelas->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        $jawaban = JawabanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $nilai = $jawaban?->nilai;

        return view('tugas.show', [
            'tugas' => $tugas,
            'siswa' => $siswa,
            'jawaban' => $jawaban,
            'nilai' => $nilai,
        ]);
    }

    public function jawab(Request $request, Tugas $tugas)
    {
        $request->validate([
            'jawaban' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if (empty($request->jawaban) && !$request->hasFile('file_path')) {
            return redirect()->back()
                ->withErrors(['file_path' => 'Isi jawaban teks atau unggah file wajib diisi salah satu.'])
                ->withInput();
        }

        $siswa = Auth::user()->siswa;

        if (!$siswa || $siswa->kelas_id !== $tugas->kelas_id) {
            abort(403, 'Akses ditolak.');
        }

        $jawaban = JawabanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        // Jika belum ada, buat jawaban pertama
        if (!$jawaban) {
            $jawaban = new JawabanTugas([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'submit_count' => 1,
            ]);
        } elseif ($jawaban->submit_count >= 2) {
            return redirect()->back()->with('error', 'Kamu sudah mencapai batas maksimal pengiriman jawaban (2 kali).');
        } else {
            $jawaban->submit_count += 1;
        }

        $jawaban->jawaban = $request->jawaban;
        $jawaban->submitted_at = now();

        if ($request->hasFile('file_path')) {
            $filename = $request->file('file_path')->store('jawaban_tugas', 'public');
            $jawaban->file_path = $filename;
        }

        $jawaban->save();

        return redirect()->route('tugas.kelas-mapel', [
            'kelas' => $tugas->kelas->slug,
            'mataPelajaran' => $tugas->mataPelajaran->slug,
        ])->with('success', 'Jawaban berhasil dikirim.');
    }


    public function belumDikerjakanPerKelas(Kelas $kelas)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            abort(403, 'Akses hanya untuk murid.');
        }

        // Cek apakah siswa tergabung dalam kelas tersebut
        if ($siswa->kelas_id !== $kelas->id) {
            abort(403, 'Anda tidak tergabung dalam kelas ini.');
        }

        $tugasBelum = Tugas::where('kelas_id', $kelas->id)
            ->whereDoesntHave('jawaban', fn($q) => $q->where('siswa_id', $siswa->id))
            ->with(['mataPelajaran', 'kelas'])
            ->orderByDesc('tanggal_deadline')
            ->get();

        return view('tugas.belum', [
            'tugasBelum' => $tugasBelum,
            'kelas' => $kelas,
        ]);
    }

    // Guru Section
    public function create(MataPelajaran $mataPelajaran, Kelas $kelas)
    {

        $tugasList = Tugas::where('mapel_id', $mataPelajaran->id)
            ->where('kelas_id', $kelas->id)
            ->latest()->get();

        return view('guru.tugas.create', [
            'mataPelajaran' => $mataPelajaran,
            'kelas' => $kelas,
            'tugasList' => $tugasList,
        ]);
    }

    public function store(Request $request, MataPelajaran $mataPelajaran, Kelas $kelas)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_deadline' => 'required|date|after_or_equal:today',
            'files' => 'nullable|array|max:3',
            'files.*' => 'file|mimes:pdf,doc,docx|max:4096',
            'youtube_link' => 'nullable|url',
        ]);

        $tugasSebelumnya = Tugas::where('mapel_id', $mataPelajaran->id)
            ->where('kelas_id', $kelas->id)
            ->get();

        $versiTerakhir = $tugasSebelumnya->max('versi') ?? 1;
        $jumlahPadaVersiTerakhir = $tugasSebelumnya->where('versi', $versiTerakhir)->count();
        $versiBaru = $jumlahPadaVersiTerakhir >= 16 ? $versiTerakhir + 1 : $versiTerakhir;

        $tugas = Tugas::create([
            'mapel_id' => $mataPelajaran->id,
            'kelas_id' => $kelas->id,
            'versi' => $versiBaru,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_deadline' => $request->tanggal_deadline,
            'link_video' => $request->youtube_link,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('tugas_files', 'public');
                TugasFile::create([
                    'tugas_id' => $tugas->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('guru.tugas.create', [
            $mataPelajaran->slug,
            $kelas->slug,
        ])->with('success', "Tugas berhasil dibuat pada versi ke-{$versiBaru}.");
    }

    public function detail(MataPelajaran $mataPelajaran, Kelas $kelas, Tugas $tugas)
    {
        $tugas->load(['mataPelajaran', 'kelas', 'jawaban.nilai']);

        $siswaList = Siswa::with('user')
            ->where('kelas_id', $kelas->id)
            ->paginate(10);

        return view('guru.tugas.detail', [
            'tugas' => $tugas,
            'siswaList' => $siswaList,
        ]);
    }

    public function beriNilai(Request $request, $jawaban)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $jawaban = JawabanTugas::with('nilai', 'tugas')->findOrFail($jawaban);

        $nilai = $jawaban->nilai ?? new Nilai();
        $nilai->fill([
            'siswa_id' => $jawaban->siswa_id,
            'mapel_id' => $jawaban->tugas->mapel_id,
            'tugas_id' => $jawaban->tugas_id,
            'jawaban_tugas_id' => $jawaban->id,
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
        ]);
        $nilai->save();

        return back()->with('success', 'Nilai dan feedback berhasil disimpan.');
    }
}
