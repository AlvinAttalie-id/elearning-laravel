<x-app-layout>

    <div class="px-4 py-10 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        <!-- Filter Jenjang -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-blue-600 fas fa-list-ul"></i> Daftar Kelas
            </h2>

            <form method="GET" class="flex items-center gap-3">
                <label for="jenjang" class="text-sm text-gray-600">Filter Jenjang:</label>
                <select name="jenjang" id="jenjang" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="X" {{ request('jenjang') == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ request('jenjang') == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ request('jenjang') == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
            </form>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($kelasBelumJoin as $kelas)
                @php
                    $jumlahMapel = $kelas->mataPelajaran->count();
                    $mapelPreview = $kelas->mataPelajaran->take(3);
                @endphp

                <div class="relative p-6 transition duration-200 bg-white shadow rounded-xl hover:shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="mr-2 text-indigo-500 fas fa-chalkboard-teacher"></i>
                            {{ $kelas->nama }}
                        </h3>

                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold text-white
    {{ $kelas->siswa_count >= $kelas->maksimal_siswa ? 'bg-red-600' : 'bg-green-600' }} rounded-full">
                            {{ $kelas->siswa_count }} / {{ $kelas->maksimal_siswa }} Murid
                        </span>

                    </div>

                    <p class="mb-1 text-sm text-gray-600">
                        <strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}
                    </p>

                    <p class="mb-1 text-sm text-gray-600">
                        <strong>Mata Pelajaran:</strong>
                        @foreach ($mapelPreview as $mapel)
                            {{ $mapel->nama_mapel }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                        @if ($jumlahMapel > 3)
                            ...
                        @endif
                    </p>

                    <div class="flex justify-end mt-4">
                        @if ($kelas->siswa_count >= $kelas->maksimal_siswa)
                            <button disabled
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gray-400 rounded-full shadow cursor-not-allowed">
                                <i class="fas fa-lock"></i>
                                Kelas Penuh
                            </button>
                        @elseif ($kelasSaya && $kelasSaya != $kelas->id)
                            <button disabled
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gray-400 rounded-full shadow cursor-not-allowed">
                                <i class="fas fa-ban"></i>
                                Sudah Bergabung di Kelas Lain
                            </button>
                        @else
                            <a href="{{ route('kelas.show', $kelas->slug) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-blue-600 rounded-full shadow hover:bg-blue-700 hover:shadow-md active:bg-blue-800">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>
                        @endif

                    </div>
                </div>
                @empty
                    <div class="text-center text-gray-500 col-span-full">
                        <p><i class="mr-2 fas fa-info-circle"></i> Semua kelas telah Anda ikuti.</p>
                    </div>
                @endforelse


            </div>

            {{-- Pagination --}}
            @if (!$filterJenjang)
                <div class="mt-6">
                    {{ $daftarKelas->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
        </div>
        </div>
    </x-app-layout>
