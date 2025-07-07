<x-app-layout>
    <div class="max-w-4xl px-4 py-10 mx-auto space-y-8 sm:px-6 lg:px-8" x-data="{ showModal: false }">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-blue-600 fas fa-tasks"></i> Tugas untuk {{ $mapel->nama_mapel }} -
                {{ $kelas->nama }}
            </h2>
            <button @click="showModal = true"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded shadow hover:bg-blue-700">
                <i class="fas fa-plus-circle"></i>
                Tambah Tugas
            </button>
        </div>

        {{-- Modal Tambah Tugas --}}
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                @click.away="showModal = false" class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Buat Tugas Baru</h3>
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('guru.tugas.store', [$mapel->id, $kelas->id]) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Judul Tugas</label>
                        <input type="text" name="judul" required class="w-full px-4 py-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-md"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Tanggal Deadline</label>
                        <input type="date" name="tanggal_deadline" required class="px-4 py-2 border rounded-md" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showModal = false"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar Tugas --}}
        <div class="mt-10 space-y-6">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="mr-2 text-indigo-600 fas fa-folder-open"></i> Tugas Sebelumnya
            </h3>

            @forelse ($tugasList as $tugas)
                <div class="p-4 bg-white border rounded shadow">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-700">{{ $tugas->judul }}</h4>
                        <span class="text-sm text-gray-500">Deadline:
                            {{ $tugas->tanggal_deadline->format('d M Y') }}</span>
                    </div>
                    <p class="mt-2 text-gray-600">{{ $tugas->deskripsi ?? '-' }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada tugas untuk kelas ini.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
