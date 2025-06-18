<x-app-layout>

    <div class="flex items-center gap-3">
        <i data-lucide="clipboard-list" class="w-6 h-6 text-indigo-600"></i>
        <h2 class="text-2xl font-bold text-gray-800">Tugas - {{ $mapel->nama_mapel }} ({{ $kelas->nama }})</h2>
    </div>

    <div class="py-6">
        <div class="mx-auto space-y-5 max-w-7xl sm:px-6 lg:px-8">
            @forelse ($tugas as $t)
                @php
                    $isLate = $t->tanggal_deadline->isPast();
                    $jawaban = $t->jawaban->where('siswa_id', auth()->user()->siswa->id)->first();
                @endphp

                <div
                    class="relative p-6 overflow-hidden transition bg-white border border-gray-200 shadow rounded-xl hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">
                                <i data-lucide="file-text" class="w-5 h-5 text-blue-500"></i>
                                {{ $t->judul }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $t->deskripsi }}</p>
                        </div>

                        <div class="flex flex-col items-end space-y-1">
                            {{-- Deadline --}}
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white rounded-full {{ $isLate ? 'bg-red-600' : 'bg-green-600' }}">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                {{ $t->tanggal_deadline->format('d M Y') }}
                            </span>

                            {{-- Status Jawaban --}}
                            @if ($jawaban)
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white rounded-full bg-emerald-600">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    Sudah dikerjakan
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white bg-yellow-500 rounded-full">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    Belum dikerjakan
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Jawab --}}
                    <div class="mt-4">
                        <a href="{{ route('tugas.show', [$kelas->id, $mapel->id, $t->id]) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Jawab Tugas
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-sm italic text-center text-gray-500 bg-white border rounded-xl">
                    <i data-lucide="inbox" class="inline w-5 h-5 mr-1 text-gray-400"></i>
                    Belum ada tugas untuk mata pelajaran ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="fixed z-40 bottom-8 left-8">
        <a href="{{ route('kelas.show-saya', $kelas->id) }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

</x-app-layout>
