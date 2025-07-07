<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        ]);

        // Simpan user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Beri role "Guru"
        $user->assignRole('Guru');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
