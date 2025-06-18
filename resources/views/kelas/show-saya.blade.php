<x-app-layout>

    <div class="px-4 py-10 mx-auto space-y-10 max-w-7xl sm:px-6 lg:px-8" x-data="{ showKeluarModal: false }">
        <div class="flex items-center gap-3">
            <i data-lucide="school" class="w-6 h-6 text-indigo-500"></i>
            <h2 class="text-2xl font-bold text-gray-800">Kelas Saya: {{ $kelas->nama }}</h2>
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

        {{-- Daftar Mata Pelajaran --}}
        <div class="space-y-4">
            <h4 class="text-lg font-semibold text-gray-800">Mata Pelajaran</h4>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($mapelList as $mapel)
                    <div
                        class="p-6 transition bg-white border border-gray-200 rounded-2xl hover:shadow-md hover:border-gray-300">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h5 class="text-lg font-semibold text-gray-800">
                                    {{ $mapel->nama }}
                                </h5>
                                <p class="text-sm text-gray-500">Kode: #{{ $mapel->id }}</p>
                            </div>
                            @if ($mapel->jumlah_tugas_belum > 0)
                                <div class="relative">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 text-white bg-green-600 rounded-full shadow">
                                        <i data-lucide="bell" class="w-4 h-4"></i>
                                    </span>
                                    <span
                                        class="absolute -top-1 -right-1 min-w-[1.2rem] h-[1.2rem] px-1 text-[10px] font-bold text-green-600 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        {{ $mapel->jumlah_tugas_belum }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <p class="mt-2 text-sm text-gray-600">
                            <i data-lucide="user" class="inline w-4 h-4 mr-1 text-gray-500"></i>
                            {{ $mapel->guru }}
                        </p>

                        <div class="mt-4">
                            <a href="{{ route('tugas.kelas-mapel', ['kelas' => $kelas->id, 'mapel' => $mapel->id]) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Masuk
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="italic text-gray-500 col-span-full">
                        Tidak ada mata pelajaran untuk kelas ini.
                    </div>
                @endforelse

            </div>
        </div>

        {{-- Tombol Floating Keluar --}}
        <div class="fixed z-50 bottom-8 right-8">
            <button @click="showKeluarModal = true" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-full shadow-lg hover:bg-red-700">
                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                Keluar Kelas
            </button>
        </div>

        {{-- Tombol Floating Kembali --}}
        <div class="fixed z-50 bottom-8 left-8">
            <a href="{{ route('kelas.saya') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Kembali
            </a>
        </div>

        {{-- Modal Konfirmasi Keluar --}}
        <div x-show="showKeluarModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showKeluarModal = false" class="w-full max-w-md p-6 bg-white shadow-lg rounded-xl">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">
                    Konfirmasi Keluar Kelas
                </h2>
                <p class="mb-6 text-sm text-gray-600">
                    Apakah Anda yakin ingin keluar dari kelas <strong>{{ $kelas->nama }}</strong>?
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showKeluarModal = false"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600">
                        Batal
                    </button>
                    <form action="{{ route('kelas.keluar', $kelas->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
