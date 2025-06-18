<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-100 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-6 space-y-6 bg-white border border-gray-200 shadow-md rounded-2xl">
            <div class="text-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <h2 class="mt-1 text-lg font-semibold text-gray-700">Masuk ke akun Anda</h2>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-gray-500 hover:text-indigo-600">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500">
                    Masuk
                </button>

                {{-- Register Link --}}
                <p class="text-sm text-center text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
