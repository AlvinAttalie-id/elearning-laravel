<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-100 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-6 space-y-6 bg-white border border-gray-200 shadow-md rounded-2xl">
            <div class="text-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <h2 class="mt-1 text-lg font-semibold text-gray-700">Buat akun baru</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                    <input id="alamat" name="alamat" type="text" value="{{ old('alamat') }}" required
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-1 text-xs" />
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="tanggal_lahir" class="block mb-1 text-sm font-medium text-gray-700">Tanggal
                        Lahir</label>
                    <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}"
                        required
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-1 text-xs" />
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password"
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-between">
                    <a class="font-medium text-indigo-600 hover:underline" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
