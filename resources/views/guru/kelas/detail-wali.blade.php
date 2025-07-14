<x-app-layout>
    <div class="px-4 py-10 mx-auto space-y-10 max-w-7xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-indigo-600 fas fa-user-shield"></i> Detail Kelas: {{ $kelas->nama }} (Sebagai Wali
                Kelas)
            </h2>
        </div>

        {{-- Mata Pelajaran --}}
        <div class="flex items-center gap-3 mt-12">
            <div class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full">
                <i data-lucide="book" class="w-5 h-5"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Mata Pelajaran di Kelas Ini</h3>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($kelas->mataPelajaran as $mapel)
                <div class="relative p-6 transition duration-200 bg-white shadow rounded-xl hover:shadow-md">
                    <div class="mb-3">
                        <h4 class="flex items-center text-lg font-semibold text-gray-800">
                            <i class="mr-2 text-purple-500 fas fa-book-open"></i>
                            {{ $mapel->nama_mapel }}
                        </h4>
                        <p class="text-sm text-gray-600">
                            <strong>Guru:</strong> {{ $mapel->guru->user->name ?? '-' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 col-span-full">
                    <p><i class="fas fa-info-circle"></i> Belum ada mata pelajaran di kelas ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Tabel Data Siswa --}}
        <div class="flex items-center gap-3 mt-10">
            <div class="flex items-center justify-center w-10 h-10 text-green-600 bg-green-100 rounded-full">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">Daftar Siswa</h3>
        </div>

        @if ($siswaList->count())
            <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm rounded-xl">
                <table class="w-full text-sm text-left table-auto">
                    <thead class="font-semibold text-gray-700 bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">NIS</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswaList as $i => $siswa)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $siswaList->firstItem() + $i }}</td>
                                <td class="px-4 py-2 font-medium text-gray-800 border">{{ $siswa->user->name }}</td>
                                <td class="px-4 py-2 border">{{ $siswa->nis ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $siswa->user->email }}</td>
                                <td class="px-4 py-2 text-center border">
                                    <a href="{{ route('guru.kelas.detail-nilai', $siswa->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition-all duration-150">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $siswaList->links() }}
            </div>
        @else
            <div class="py-12 text-center text-gray-500">
                <div class="flex flex-col items-center justify-center">
                    <i data-lucide="user-x" class="w-12 h-12 mb-4 text-gray-400"></i>
                    <p class="text-lg font-semibold">Belum ada siswa dalam kelas ini.</p>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
