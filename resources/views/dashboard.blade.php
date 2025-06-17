<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Dashboard
            </h2>

            @role('Admin')
                <span class="text-sm text-gray-600">👑 Selamat datang, Admin</span>
                @elserole('Guru')
                <span class="text-sm text-gray-600">📘 Halo, Guru</span>
                @elserole('Murid')
                <span class="text-sm text-gray-600">🎓 Hai, Murid</span>
            @endrole
        </div>
    </x-slot>

    <div class="px-4 py-8 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        {{-- Seksi Fitur Utama --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-dashboard.card icon="check-circle" title="You're logged in!"
                description="Enjoy exploring your application dashboard." />
            <x-dashboard.card icon="user-cog" title="Profile Settings"
                description="Update your profile and preferences." link="{{ route('profile.edit') }}" />
            <x-dashboard.card icon="history" title="Activity Logs"
                description="See recent login and activity history." />
        </div>

        {{-- Seksi Kelas Saya --}}
        @role('Murid')
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">📚 Kelas Anda</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($kelasSaya->take(3) as $kelas)
                        <div class="p-5 transition bg-white shadow rounded-xl hover:shadow-lg">
                            <h4 class="text-lg font-bold text-gray-900">{{ $kelas->nama }}</h4>
                            <p class="text-sm text-gray-600">Wali Kelas: {{ $kelas->waliKelas->user->name ?? '-' }}</p>
                            <a href="{{ route('kelas.show', $kelas->id) }}"
                                class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-800">
                                Lihat Detail →
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500">Belum tergabung di kelas manapun.</div>
                    @endforelse
                </div>

                @if ($kelasSaya->count() > 3)
                    <div class="text-right">
                        <a href="{{ route('kelas.saya') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-indigo-600 rounded-full hover:bg-indigo-700">
                            Lihat Semua Kelas Anda
                            <i class="ml-2 lucide lucide-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endrole
    </div>
</x-app-layout>
