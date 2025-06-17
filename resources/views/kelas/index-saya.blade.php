<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-900">
                {{ __('Kelas Anda') }}
            </h2>
            @role('Admin')
                <span class="text-sm text-gray-500">Halo, Admin!</span>
                @elserole('Guru')
                <span class="text-sm text-gray-500">Halo, Guru!</span>
                @elserole('Murid')
                <span class="text-sm text-gray-500">Halo, Murid!</span>
            @endrole
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($kelasSaya as $kelas)
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
                                class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-full">
                                {{ $kelas->siswa->count() }} Murid
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
                            <a href="{{ route('kelas.show-saya', $kelas->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-blue-600 rounded-full shadow hover:bg-blue-700 hover:shadow-md active:bg-blue-800">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @empty
                        <div class="text-center text-gray-500 col-span-full">
                            <p><i class="mr-2 fas fa-info-circle"></i> Anda belum tergabung di kelas manapun.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </x-app-layout>
