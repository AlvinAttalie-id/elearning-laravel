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
            <div class="p-6 transition duration-300 bg-white shadow rounded-xl hover:shadow-sm">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($kelasSaya->take(3) as $kelas)
                        <div
                            class="p-6 transition bg-white border border-gray-200 shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full">
                                    <i data-lucide="school" class="w-5 h-5"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    {{ $kelas->nama }}
                                </h4>
                            </div>

                            <p class="mb-4 text-sm text-gray-600">
                                <span class="font-medium text-gray-700">Wali Kelas:</span>
                                {{ $kelas->waliKelas->user->name ?? '-' }}
                            </p>

                            <a href="{{ route('kelas.show-saya', $kelas->id) }}"
                                class="inline-flex items-center text-sm font-medium text-blue-600 transition hover:text-blue-800">
                                <i data-lucide="eye" class="w-4 h-4 mr-1.5"></i>
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-12">
                                <img src="{{ asset('images/dashboard-logo.svg') }}" alt="Belum Ada Kelas"
                                    class="w-40 h-40 mb-6">
                                <p class="mb-1 text-lg font-semibold text-gray-600">
                                    Belum tergabung di kelas manapun.
                                </p>
                                <p class="text-sm text-gray-500">
                                    Silakan hubungi admin atau wali kelas untuk bergabung.
                                </p>
                                <a href="{{ route('kelas.index') }}"
                                    class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-green-700 border border-green-600 rounded-full transition hover:bg-green-600 hover:text-white">
                                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                    Gabung Kelas
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Timbil Lihat Semua kelas --}}
                @if ($kelasSaya->count() > 3)
                    <div class="mt-8 text-right">
                        <a href="{{ route('kelas.saya') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition">
                            Lihat Semua Kelas Anda
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                @endif
            </div>

        @endrole

        {{-- CARD TUGAS --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex items-center justify-center w-10 h-10 text-yellow-600 bg-yellow-100 rounded-full">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            </div>
            <h4 class="text-xl font-semibold text-gray-800">Tugas Anda</h4>
        </div>
        <div class="p-6 transition duration-300 bg-white shadow rounded-xl hover:shadow-sm">
            @if ($tugasBelumDikerjakan->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($tugasBelumDikerjakan->take(3) as $tugas)
                        <div class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300"
                            data-aos="fade-up">
                            <div class="flex items-start gap-4 mb-4">
                                {{-- Icon --}}
                                <div
                                    class="flex items-center justify-center w-12 h-12 text-indigo-600 bg-indigo-100 rounded-full">
                                    <i data-lucide="book-open-check" class="w-5 h-5"></i>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $tugas->judul }}
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Mata Pelajaran:
                                        <span class="font-medium text-gray-700">
                                            {{ $tugas->mapel->nama_mapel ?? '-' }}
                                        </span>
                                    </p>

                                    {{-- Badges --}}
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        {{-- Tanggal Deadline --}}
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                            <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                            <span class="font-semibold">Deadline:</span>
                                            &nbsp;{{ $tugas->tanggal_deadline->translatedFormat('d F Y') }}
                                        </span>

                                        {{-- Jam Deadline --}}
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">
                                            <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                                            {{ $tugas->tanggal_deadline->translatedFormat('H:i') }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4 text-right">
                                <a href="{{ route('tugas.show', [
                                    'kelas' => $tugas->kelas_id,
                                    'mapel' => $tugas->mapel_id,
                                    'tugas' => $tugas->id,
                                ]) }}"
                                    class="inline-flex items-center justify-center w-10 h-10 text-indigo-700 transition border border-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white"
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
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition">
                            Lihat Semua Tugas
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div
                        class="flex items-center justify-center w-16 h-16 mb-4 text-green-600 bg-green-100 rounded-full">
                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">✅ Tidak ada tugas yang harus dikerjakan.</p>
                </div>
            @endif
        </div>

    </div>

    </div>

    </div>
</x-app-layout>
