<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-100 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-6 space-y-6 bg-white border border-gray-200 shadow-md rounded-2xl">
            <div class="text-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <h2 class="mt-1 text-lg font-semibold text-gray-700">Daftar Sebagai Pengajar</h2>
            </div>

            <form method="POST" action="{{ route('register.guru.store') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password"
                        class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label for="no_hp" class="block mb-1 text-sm font-medium text-gray-700">Nomor HP</label>
                    <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" required
                        class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-1 text-xs" />
                </div>


                {{-- Submit --}}
                <div class="flex items-center justify-between">
                    <a class="font-medium text-indigo-600 hover:underline" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:ring-indigo-500">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
