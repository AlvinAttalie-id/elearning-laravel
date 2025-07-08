<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TugasFile;

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

        // Validasi format file dan teks
        $request->validate([
            'jawaban' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

        ]);

        // Harus isi teks atau unggah file
        if (empty($request->jawaban) && !$request->hasFile('file_path')) {
            return redirect()->back()
                ->withErrors([
                    'file_path' => 'Isi jawaban teks atau unggah file wajib diisi salah satu.'
                ])
                ->withInput();
        }

        $user = Auth::user();
        $siswa = $user->siswa;
        $tugas = Tugas::findOrFail($tugasId);

        // Pastikan siswa dari kelas yang sesuai
        if (!$siswa || $siswa->kelas_id !== $tugas->kelas_id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek jika sudah menjawab
        $existing = JawabanTugas::where('tugas_id', $tugasId)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah menjawab tugas ini.');
        }

        // Simpan jawaban
        $jawaban = new JawabanTugas();
        $jawaban->tugas_id = $tugasId;
        $jawaban->siswa_id = $siswa->id;
        $jawaban->jawaban = $request->jawaban;
        $jawaban->submitted_at = now();

        // Upload file jika ada
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = $file->store('jawaban_tugas', 'public');
            $jawaban->file_path = $filename;
        }

        $jawaban->save();

        return redirect()->route('tugas.kelas-mapel', [
            'kelas' => $tugas->kelas_id,
            'mapel' => $tugas->mapel_id,
        ])->with('success', 'Jawaban berhasil dikirim.');
    }

    public function belumDikerjakan()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            abort(403, 'Akses hanya untuk murid.');
        }

        $kelas = $siswa->kelas;

        $tugasBelum = Tugas::where('kelas_id', $siswa->kelas_id)
            ->whereDoesntHave('jawaban', function ($query) use ($siswa) {
                $query->where('siswa_id', $siswa->id);
            })
            ->with(['mapel', 'kelas'])
            ->orderByDesc('tanggal_deadline')
            ->get();

        return view('tugas.belum', compact('tugasBelum', 'kelas'));
    }

    //Guru Section
    public function create($mapelId, $kelasId)
    {
        $mapel = MataPelajaran::findOrFail($mapelId);
        $kelas = Kelas::findOrFail($kelasId);
        $tugasList = Tugas::where('mapel_id', $mapelId)->where('kelas_id', $kelasId)->latest()->get();

        return view('guru.tugas.create', compact('mapel', 'kelas', 'tugasList'));
    }

    public function store(Request $request, $mapelId, $kelasId)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_deadline' => 'required|date|after_or_equal:today',
            'files' => 'nullable|array|max:3',
            'files.*' => 'file|mimes:pdf,doc,docx|max:4096',
            'youtube_link' => 'nullable|url',
        ]);

        // Simpan tugas utama terlebih dahulu
        $tugas = Tugas::create([
            'mapel_id' => $mapelId,
            'kelas_id' => $kelasId,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_deadline' => $request->tanggal_deadline,
            'link_video' => $request->youtube_link,
        ]);

        // Jika ada file, simpan satu per satu ke tabel tugas_files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('tugas_files', 'public');

                TugasFile::create([
                    'tugas_id' => $tugas->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('guru.tugas.create', [$mapelId, $kelasId])
            ->with('success', 'Tugas berhasil dibuat.');
    }

    public function detail($mapelId, $kelasId, $tugasId)
    {
        // Ambil tugas sekaligus relasi kelas dan jawaban + nilai
        $tugas = Tugas::with(['mapel', 'kelas', 'jawaban.nilai'])->findOrFail($tugasId);

        // Ambil siswa di kelas tugas tersebut dengan user-nya
        $siswaList = Siswa::with('user')
            ->where('kelas_id', $tugas->kelas_id)
            ->paginate(10); // Pagination 10 per halaman

        return view('guru.tugas.detail', compact('tugas', 'siswaList'));
    }


    public function beriNilai(Request $request, $jawaban)
    {
        // Validasi input nilai dan feedback
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Ambil jawaban beserta relasi nilai & tugas
        $jawaban = JawabanTugas::with('nilai', 'tugas')->findOrFail($jawaban);

        // Ambil nilai jika sudah ada atau buat baru
        $nilai = $jawaban->nilai ?? new Nilai();
        $nilai->siswa_id = $jawaban->siswa_id;
        $nilai->mapel_id = $jawaban->tugas->mapel_id;
        $nilai->tugas_id = $jawaban->tugas_id;
        $nilai->jawaban_tugas_id = $jawaban->id;
        $nilai->nilai = $request->input('nilai');
        $nilai->feedback = $request->input('feedback');
        $nilai->save();

        return back()->with('success', 'Nilai dan feedback berhasil disimpan.');
    }
}
