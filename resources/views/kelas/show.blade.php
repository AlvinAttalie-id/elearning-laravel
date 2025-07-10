<x-app-layout>
    <div class="px-4 py-10 mx-auto space-y-10 max-w-7xl sm:px-6 lg:px-8" x-data="{ showModal: false }">
        <div class="flex items-center gap-3">
            <i data-lucide="school" class="w-6 h-6 text-indigo-500"></i>
            <h2 class="text-2xl font-bold text-gray-800">Detail Kelas: {{ $kelas->nama }}</h2>
        </div>

        {{-- Informasi Kelas --}}
        <div class="p-6 bg-white shadow rounded-xl">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Informasi Kelas</h3>
            <p class="mb-2 text-gray-700">
                <strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}
            </p>
            <p class="mb-4 text-gray-700">
                <strong>Jumlah Siswa:</strong> {{ $kelas->siswa->count() }}
            </p>
            <p class="text-gray-700">
                <strong>Total Mata Pelajaran:</strong>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                    {{ $kelas->mataPelajaran->count() }} Mapel
                </span>
            </p>
        </div>

        {{-- Daftar Mata Pelajaran (dalam satu div card) --}}
        <div class="p-6 bg-white shadow rounded-xl">
            <h4 class="mb-4 text-lg font-semibold text-gray-800">Mata Pelajaran</h4>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                @forelse ($kelas->mataPelajaran as $mapel)
                    <div class="px-4 py-2 text-gray-700 border rounded-md shadow-sm bg-gray-50 hover:bg-gray-100">
                        {{ $mapel->nama_mapel }}
                    </div>
                @empty
                    <div class="italic text-gray-500 col-span-full">
                        Tidak ada mata pelajaran
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tombol Floating Join/Keterangan --}}
        @if ($sudahJoinKelasIni)
            <button type="button" disabled
                class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-gray-400 rounded-full shadow-lg cursor-not-allowed bottom-8 right-8">
                <i class="fas fa-check-circle"></i>
                Anda Sudah Bergabung
            </button>
        @elseif ($sudahJoinKelasLain && $kelasPenuh)
            <button type="button" disabled
                class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-red-400 rounded-full shadow-lg cursor-not-allowed bottom-8 right-8">
                <i class="fas fa-ban"></i>
                Sudah Gabung Kelas Lain & Kelas Ini Penuh
            </button>
        @elseif ($sudahJoinKelasLain)
            <button type="button" disabled
                class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-gray-400 rounded-full shadow-lg cursor-not-allowed bottom-8 right-8">
                <i class="fas fa-ban"></i>
                Sudah Bergabung di Kelas Lain
            </button>
        @elseif ($kelasPenuh)
            <button type="button" disabled
                class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-red-500 rounded-full shadow-lg cursor-not-allowed bottom-8 right-8">
                <i class="fas fa-users-slash"></i>
                Kelas Sudah Penuh
            </button>
        @else
            <button type="button" @click="showModal = true"
                class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-green-600 rounded-full shadow-lg bottom-8 right-8 hover:bg-green-700">
                <i class="fas fa-sign-in-alt"></i>
                Join Kelas
            </button>
        @endif


        {{-- Tombol Floating Kembali --}}
        <div class="fixed z-50 bottom-8 left-8">
            <a href="{{ route('kelas.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Kembali
            </a>
        </div>

        {{-- Modal Join --}}
        @if (!$sudahJoinKelasIni && !$sudahJoinKelasLain && !$kelasPenuh)
            <div x-show="showModal" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="showModal = false" class="w-full max-w-md p-6 bg-white shadow-lg rounded-xl">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">
                        Konfirmasi Bergabung Kelas
                    </h2>
                    <p class="mb-6 text-sm text-gray-600">
                        Apakah Anda yakin ingin bergabung ke kelas <strong>{{ $kelas->nama }}</strong>?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button @click="showModal = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <form action="{{ route('kelas.join', $kelas->slug) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Ya, Gabung
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
