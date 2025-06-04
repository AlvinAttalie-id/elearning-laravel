@php
    $user = auth()->user();
    $role = strtolower($user->role); // pastikan lowercase agar konsisten
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email', $user->email)"
                required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Info Role -->
        <p class="text-sm text-gray-600 dark:text-gray-400">
            <strong>Role saat ini:</strong> {{ ucfirst($user->role) }}
        </p>

        <!-- Jika Guru -->
        @if ($role === 'guru')
            <div>
                <x-input-label for="nip" value="NIP" />
                <x-text-input id="nip" name="nip" type="text" class="block w-full mt-1"
                    :value="old('nip', $user->guru->nip ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            </div>

            <div>
                <x-input-label for="no_hp" value="No HP" />
                <x-text-input id="no_hp" name="no_hp" type="text" class="block w-full mt-1"
                    :value="old('no_hp', $user->guru->no_hp ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
            </div>
        @endif

        <!-- Jika murid -->
        @if ($role === 'murid')
            <div>
                <x-input-label for="nis" value="NIS" />
                <x-text-input id="nis" name="nis" type="text" class="block w-full mt-1"
                    :value="old('nis', $user->murid->nis ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('nis')" />
            </div>

            <div>
                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="block w-full mt-1"
                    :value="old('tanggal_lahir', $user->murid->tanggal_lahir ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
            </div>

            <div>
                <x-input-label for="alamat" value="Alamat" />
                <x-text-input id="alamat" name="alamat" type="text" class="block w-full mt-1"
                    :value="old('alamat', $user->murid->alamat ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>
        @endif

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
