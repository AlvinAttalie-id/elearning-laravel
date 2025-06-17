<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Kelas Saya: {{ $kelas->nama }}
        </h2>
    </x-slot>

    <div class="mx-10" x-data="{ showKeluarModal: false }">
        <div class="max-w-4xl px-4 py-6 mx-auto bg-white shadow rounded-xl">
            <h3 class="mb-3 text-lg font-semibold text-gray-800">Informasi Kelas</h3>
            <p class="mb-2 text-gray-700"><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>
            <p class="mb-2 text-gray-700"><strong>Jumlah Siswa:</strong> {{ $kelas->siswa->count() }}</p>

            <h4 class="mt-6 font-semibold text-gray-800 text-md">Mata Pelajaran</h4>
            <div class="grid grid-cols-1 gap-3 mt-2 sm:grid-cols-2 md:grid-cols-3">
                @forelse ($kelas->mataPelajaran as $mapel)
                    <div class="px-4 py-2 border rounded-md shadow-sm bg-gray-50 hover:bg-gray-100">
                        {{ $mapel->nama_mapel }}
                    </div>
                @empty
                    <div class="italic text-gray-500 col-span-full">
                        Tidak ada mata pelajaran
                    </div>
                @endforelse
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('kelas.saya') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-indigo-600 rounded-full hover:bg-indigo-700">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Kembali ke Kelas Anda
                </a>

                <!-- Tombol Trigger Modal -->
                <button @click="showKeluarModal = true" type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-full hover:bg-red-700">
                    <i class="mr-2 fas fa-sign-out-alt"></i>
                    Keluar Kelas
                </button>
            </div>
        </div>

        <!-- Modal Konfirmasi Keluar -->
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
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600">
                        Batal
                    </button>
                    <form action="{{ route('kelas.keluar', $kelas->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
