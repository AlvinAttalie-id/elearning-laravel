<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-900">
                Detail Kelas: {{ $kelas->nama }}
            </h2>
        </div>
    </x-slot>

    <div class="mx-10">
        <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('kelas.index') }}"
                    class="inline-flex items-center gap-2 px-2 py-2 text-sm font-medium text-white transition-all duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 hover:shadow-md active:bg-indigo-800">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar Kelas
                </a>
            </div>


            <div class="p-6 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Kelas</h3>
                    <div class="mt-2 space-y-2 text-gray-700">
                        <p><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>
                        <p><strong>Jumlah Siswa:</strong> {{ $kelas->siswa->count() }}</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 text-md">Mata Pelajaran</h4>
                    <div class="grid grid-cols-1 gap-3 mt-3 text-gray-700 sm:grid-cols-2 md:grid-cols-3">
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


                    <!-- Tombol Join Kelas (floating) -->
                    <a href="#"
                        class="fixed z-50 flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white transition-all duration-300 bg-green-600 rounded-full shadow-lg bottom-6 right-6 hover:bg-green-700 hover:shadow-xl">
                        <i class="fas fa-sign-in-alt"></i>
                        Join Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
