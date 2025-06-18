<x-app-layout>
    <div class="px-4 py-12 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8">
        <!-- Judul Halaman -->
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full">
                <i data-lucide="clipboard-x" class="w-5 h-5 text-red-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Tugas Belum Dikerjakan</h2>
        </div>

        <!-- Daftar Tugas -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($tugasBelum as $t)
                <div
                    class="flex flex-col justify-between h-full p-6 transition-all duration-300 bg-white border border-gray-200 shadow rounded-2xl hover:shadow-lg">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-500"></i>
                            <span>{{ $t->judul }}</span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-3">
                            {{ $t->deskripsi }}
                        </p>
                    </div>

                    <div class="mt-4 space-y-2">
                        <!-- Deadline -->
                        <div class="flex items-center gap-2 text-xs font-medium">
                            <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                            <span
                                class="px-2 py-1 rounded-full text-white {{ $t->tanggal_deadline->isPast() ? 'bg-red-600' : 'bg-green-600' }}">
                                {{ $t->tanggal_deadline->format('d M Y') }}
                            </span>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center gap-2 text-xs font-medium">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-yellow-500"></i>
                            <span class="px-2 py-1 text-white bg-yellow-500 rounded-full">
                                Belum dikerjakan
                            </span>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6">
                        <a href="{{ route('tugas.show', [$t->kelas_id, $t->mapel_id, $t->id]) }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                            Jawab Tugas
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 bg-white border border-gray-200 col-span-full rounded-2xl">
                    <i data-lucide="inbox" class="inline w-5 h-5 mr-1 text-gray-400"></i>
                    Semua tugas sudah dikerjakan 🎉
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="fixed z-40 bottom-6 left-6">
        <a href="{{ route('kelas.saya') }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>
</x-app-layout>
