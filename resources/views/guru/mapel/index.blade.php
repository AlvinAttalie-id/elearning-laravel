<x-app-layout>
    <div class="px-4 py-10 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-indigo-600 fas fa-book-open"></i> Mata Pelajaran Anda
            </h2>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($mataPelajaranGuru as $mapel)
                <div class="relative p-6 transition duration-200 bg-white shadow rounded-xl hover:shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="mr-2 text-blue-500 fas fa-book"></i>
                            {{ $mapel->nama_mapel }}
                        </h3>

                        <span class="inline-block px-3 py-1 text-xs font-semibold text-white bg-indigo-600 rounded-full">
                            ID: {{ $mapel->slug }}
                        </span>
                    </div>

                    <p class="mb-1 text-sm text-gray-600">
                        <strong>Dipegang Oleh:</strong> {{ $mapel->guru->user->name ?? '-' }}
                    </p>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('guru.mapel.kelas', $mapel->slug) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-indigo-600 rounded-full shadow hover:bg-indigo-700 hover:shadow-md">
                            <i class="fas fa-chalkboard"></i>
                            Pilih Kelas
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 col-span-full">
                    <p><i class="mr-2 fas fa-info-circle"></i> Anda belum memiliki mata pelajaran.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
