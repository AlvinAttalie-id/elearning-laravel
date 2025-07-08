<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterGuruController extends Controller
{
    /**
     * Tampilkan form registrasi pengajar
     */
    public function create(): View
    {
        return view('auth.register-pengajar'); // Blade: resources/views/auth/register-pengajar.blade.php
    }

    /**
     * Simpan data registrasi pengajar
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp'    => ['required', 'string', 'max:20'],
        ]);

        // Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Role Guru
        $user->assignRole('Guru');

        // Generate NIP
        $today = now()->format('ymd');
        $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $nip = '00' . $today . $random;

        // Buat data guru
        Guru::create([
            'user_id' => $user->id,
            'nip' => $nip,
            'no_hp' => $request->no_hp,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
