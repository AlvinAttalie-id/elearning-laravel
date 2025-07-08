<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        if ($guru->mataPelajaran()->exists()) {
            $mataPelajaranGuru = $guru->mataPelajaran;
            return view('guru.mapel.index', compact('mataPelajaranGuru'));
        }

        // Jika belum punya mata pelajaran, kirimkan array kosong ke view
        return view('guru.mapel.index', [
            'mataPelajaranGuru' => collect([]),
        ]);
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

    public function kelasList($mapelId)
    {
        $guru = Auth::user()->guru;

        $mapel = MataPelajaran::with('kelas')->where('id', $mapelId)->where('guru_id', $guru->id)->firstOrFail();

        $kelasList = $mapel->kelas;

        return view('guru.kelas.index', compact('mapel', 'kelasList'));
    }
}
