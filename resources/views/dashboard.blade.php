<x-app-layout>

    <div class="px-4 py-10 mx-auto space-y-12 max-w-7xl sm:px-6 lg:px-8">
        {{-- Kelas Saya --}}
        @role('Murid')
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="book" class="w-6 h-6 text-indigo-500"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas Saya</h2>
                </div>
            </div>

            <div class="p-6 transition duration-300 bg-white shadow rounded-xl hover:shadow-sm">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($kelasSaya->take(3) as $kelas)
                        <div
                            class="p-6 transition bg-white border border-gray-200 shadow-sm rounded-2xl hover:shadow-md hover:border-gray-300">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full">
                                    <i data-lucide="school" class="w-5 h-5"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    {{ $kelas->nama }}
                                </h4>
                            </div>

                            <p class="mb-4 text-sm text-gray-600">
                                <span class="font-medium text-gray-700">Wali Kelas:</span>
                                {{ $kelas->waliKelas->user->name ?? '-' }}
                            </p>

                            <a href="{{ route('kelas.show-saya', $kelas->id) }}"
                                class="inline-flex items-center text-sm font-medium text-blue-600 transition hover:text-blue-800">
                                <i data-lucide="eye" class="w-4 h-4 mr-1.5"></i>
                                Lihat Detail
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-12">
                                <img src="{{ asset('images/dashboard-logo.svg') }}" alt="Belum Ada Kelas"
                                    class="w-40 h-40 mb-6">

                                <p class="mb-1 text-lg font-semibold text-gray-600">
                                    Belum tergabung di kelas manapun.
                                </p>
                                <p class="text-sm text-gray-500">
                                    Silakan hubungi admin atau wali kelas untuk bergabung.
                                </p>

                                <a href="{{ route('kelas.index') }}"
                                    class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-green-700 border border-green-600 rounded-full transition hover:bg-green-600 hover:text-white">
                                    <i data-lucide="log-in" class="w-4 h-4 mr-2"></i>
                                    Gabung Kelas
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Tombol Lihat Semua --}}
                @if ($kelasSaya->count() > 3)
                    <div class="mt-8 text-right">
                        <a href="{{ route('kelas.saya') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition">
                            Lihat Semua Kelas Anda
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                @endif
            @endrole
        </div>
        {{-- Konten Kelas --}}


    </div>
</x-app-layout>
