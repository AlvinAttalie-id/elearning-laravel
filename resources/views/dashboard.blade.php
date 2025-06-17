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
        <x-dashboard.card icon="check-circle" title="You're logged in!"
            description="Enjoy exploring your application dashboard." />

        {{-- Kelas Saya --}}
        @role('Murid')
            <div class="p-6 transition duration-300 bg-white shadow rounded-xl hover:shadow-md">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Kelas Anda</h3>
                    <i data-lucide="book" class="w-6 h-6 text-indigo-500"></i>
                </div>

                {{-- Konten Kelas --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($kelasSaya->take(3) as $kelas)
                        <div class="p-5 transition border rounded-xl bg-gray-50 hover:bg-gray-100">
                            <h4 class="text-lg font-bold text-gray-900">{{ $kelas->nama }}</h4>
                            <p class="text-sm text-gray-600">
                                Wali Kelas: {{ $kelas->waliKelas->user->name ?? '-' }}
                            </p>
                            <a href="{{ route('kelas.show-saya', $kelas->id) }}"
                                class="inline-block mt-3 text-sm font-medium text-blue-600 hover:text-blue-800">
                                Lihat Detail →
                            </a>
                        </div>
                    @empty
                        {{-- Jika tidak ada kelas --}}
                        <div class="col-span-3 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-10">
                                {{-- Gambar SVG --}}
                                <img src="{{ asset('images/dashboard-logo.svg') }}" alt="Belum Ada Kelas"
                                    class="w-40 h-40 mb-4">

                                {{-- Teks --}}
                                <p class="text-lg font-semibold text-gray-600">Belum tergabung di kelas manapun.</p>
                                <p class="text-sm text-gray-500">Silakan hubungi admin atau wali kelas untuk bergabung.</p>

                                {{-- Tombol Join --}}
                                <a href="{{ route('kelas.index') }}"
                                    class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-medium text-green-700 border border-green-600 rounded-full transition hover:bg-green-600 hover:text-white">
                                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                    Gabung Kelas
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Tombol Lihat Semua --}}
                @if ($kelasSaya->count() > 3)
                    <div class="mt-6 text-right">
                        <a href="{{ route('kelas.saya') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-indigo-600 rounded-full hover:bg-indigo-700">
                            Lihat Semua Kelas Anda
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endrole

    </div>
</x-app-layout>
