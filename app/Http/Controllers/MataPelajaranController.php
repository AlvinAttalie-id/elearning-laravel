<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda belum terdaftar sebagai guru.');
        }

        $mataPelajaranGuru = $guru->mataPelajaran ?? collect();

        return view('guru.mapel.index', compact('mataPelajaranGuru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel' => 'required|array',
            'mapel.*' => 'exists:mata_pelajaran,id'
        ]);

        $guru = Auth::user()->guru;

        MataPelajaran::whereIn('id', $request->mapel)
            ->whereNull('guru_id')
            ->update(['guru_id' => $guru->id]);

        return redirect()->route('dashboard')->with('success', 'Mata pelajaran berhasil disimpan.');
    }

    // Contoh di MataPelajaranController
    public function kelasList(MataPelajaran $mataPelajaran)
    {
        $guru = Auth::user()->guru;

        if ($mataPelajaran->guru_id !== $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke mata pelajaran ini.');
        }

        $kelasList = $mataPelajaran->kelas;

        return view('guru.kelas.index', compact('mataPelajaran', 'kelasList'));
    }
}
