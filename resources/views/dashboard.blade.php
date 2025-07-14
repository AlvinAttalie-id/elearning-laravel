<x-app-layout>
    <div class="px-4 py-10 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        @role('Murid')

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="book" class="w-6 h-6 text-indigo-500"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas Saya</h2>
                </div>
            </div>

            {{-- CARD KELAS SAYA --}}
            <div class="p-6 bg-white shadow rounded-xl">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($kelasSaya->take(3) as $kelas)
                        <div class="p-6 border shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full">
                                    <i data-lucide="school" class="w-5 h-5"></i>
                                </div>
                                <h4 class="text-lg font-semibold">{{ $kelas->nama }}</h4>
                            </div>

                            <p class="mb-4 text-sm text-gray-600">
                                <span class="font-medium">Wali Kelas:</span> {{ $kelas->waliKelas->user->name ?? '-' }}
                            </p>

                            <a href="{{ route('kelas.show-saya', $kelas->slug) }}"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="eye" class="inline w-4 h-4 mr-1"></i>
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-12">
                                <img src="{{ asset('images/dashboard-logo.svg') }}" alt="Belum Ada Kelas"
                                    class="w-40 h-40 mb-6">
                                <p class="mb-1 text-lg font-semibold">Belum tergabung di kelas manapun.</p>
                                <p class="mb-4 text-sm">Silakan hubungi admin atau wali kelas untuk bergabung.</p>
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-green-700 border border-green-600 rounded-full hover:bg-green-600 hover:text-white">
                                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                    Gabung Kelas
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($kelasSaya->count() > 3)
                    <div class="mt-8 text-right">
                        <a href="{{ route('kelas.saya') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700">
                            Lihat Semua Kelas Anda
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                @endif
            </div>

            {{-- TUGAS --}}
            <div class="flex items-center gap-3 mt-12 mb-6">
                <div class="flex items-center justify-center w-10 h-10 text-yellow-600 bg-yellow-100 rounded-full">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
                <h4 class="text-xl font-semibold text-gray-800">Tugas Anda</h4>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                @if ($tugasBelumDikerjakan->count())
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($tugasBelumDikerjakan->take(3) as $tugas)
                            <div class="p-6 border shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300">
                                <div class="flex items-start gap-4 mb-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 text-indigo-600 bg-indigo-100 rounded-full">
                                        <i data-lucide="book-open-check" class="w-5 h-5"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">{{ $tugas->judul }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Mata Pelajaran:
                                            <span class="font-medium text-gray-700">
                                                {{ $tugas->mataPelajaran->nama_mapel ?? '-' }}
                                            </span>
                                        </p>

                                        <div class="flex flex-wrap gap-2 mt-3">
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                                {{ $tugas->tanggal_deadline->translatedFormat('d F Y') }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">
                                                <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                                                {{ $tugas->tanggal_deadline->translatedFormat('H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('tugas.show', [
                                        'kelas' => $tugas->kelas->slug,
                                        'mataPelajaran' => $tugas->mataPelajaran->slug,
                                        'tugas' => $tugas->slug,
                                    ]) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 text-indigo-700 border border-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white"
                                        title="Kerjakan Sekarang">
                                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($tugasBelumDikerjakan->count() > 3)
                        <div class="mt-6 text-right">
                            <a href="{{ route('tugas.belum') }}"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700">
                                Lihat Semua Tugas
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-4 text-green-600 bg-green-100 rounded-full">
                            <i data-lucide="check-circle" class="w-8 h-8"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">✅ Tidak ada tugas yang harus dikerjakan.</p>
                    </div>
                @endif
            </div>
        @endrole

        @role('Guru')
            <div class="text-lg font-semibold text-gray-700">Selamat datang, Guru!</div>

            @if ($kelasWali)
                {{-- CARD WALI KELAS --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <i data-lucide="shield-check" class="w-6 h-6 text-green-600"></i>
                            <h2 class="text-2xl font-bold text-gray-800">Kelas yang Anda Bina</h2>
                        </div>
                    </div>

                    <div class="p-6 bg-white shadow rounded-xl">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div class="p-6 border shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 text-green-600 bg-green-100 rounded-full">
                                        <i data-lucide="school" class="w-5 h-5"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold">{{ $kelasWali->nama }}</h4>
                                </div>

                                <p class="mb-1 text-sm text-gray-600">
                                    <span class="font-medium">Jumlah Murid:</span> {{ $kelasWali->siswa->count() }} murid
                                </p>

                                <p class="mb-4 text-sm text-gray-600">
                                    <span class="font-medium">Jumlah Mata Pelajaran:</span>
                                    {{ $kelasWali->mataPelajaran->count() }} mapel
                                </p>

                                <a href="{{ route('guru.kelas.detail-wali', $kelasWali->slug) }}"
                                    class="text-sm text-green-600 hover:text-green-800">
                                    <i data-lucide="eye" class="inline w-4 h-4 mr-1"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endrole


    </div>
</x-app-layout>
