<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validasi umum
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Validasi & update untuk Guru
        if ($user->role === 'guru') {
            $request->validate([
                'nip' => 'required|string|max:20',
                'no_hp' => 'nullable|string|max:20',
            ]);

            $user->guru()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->nip,
                    'no_hp' => $request->no_hp,
                ]
            );
        }

        // Validasi & update untuk Siswa
        if ($user->role === 'siswa') {
            $request->validate([
                'nis' => 'required|string|max:20',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'nullable|string|max:255',
                'kelas_id' => 'required|integer',
            ]);

            $user->siswa()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $request->nis,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat' => $request->alamat,
                    'kelas_id' => $request->kelas_id,
                ]
            );
        }

        return Redirect::back()->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
