<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasSaya = [];

        if ($user->hasRole('Murid') && $user->siswa && $user->siswa->kelas) {
            $kelasSaya = collect([$user->siswa->kelas->load(['waliKelas.user', 'siswa'])]);
        }

        return view('dashboard', compact('kelasSaya'));
    }
}
