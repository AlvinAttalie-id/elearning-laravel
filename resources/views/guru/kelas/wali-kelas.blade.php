<x-app-layout>
    <div class="px-4 py-10 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-indigo-600 fas fa-users-class"></i> Wali Kelas Anda
            </h2>
        </div>

        @if ($bukanWali)
            <div class="p-6 text-center text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-lg">
                <i class="mb-2 text-2xl fas fa-info-circle"></i>
                <p class="text-sm">Anda saat ini <strong>bukan wali kelas</strong> dari kelas manapun.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="relative p-6 transition duration-200 bg-white shadow rounded-xl hover:shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="mr-2 text-blue-500 fas fa-school"></i>
                            {{ $kelas->nama }}
                        </h3>

                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-indigo-600 rounded-full">
                            Kelas ID: {{ $kelas->slug }}
                        </span>
                    </div>

                    <p class="mb-1 text-sm text-gray-600">
                        <strong>Jumlah Siswa:</strong> {{ $kelas->siswa()->count() }}
                    </p>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('guru.kelas.detail-wali', $kelas->slug) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-indigo-600 rounded-full shadow hover:bg-indigo-700 hover:shadow-md">
                            <i class="fas fa-eye"></i>
                            Lihat Detail Kelas
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
