<x-app-layout>
    <div class="max-w-4xl px-4 py-10 mx-auto space-y-8 sm:px-6 lg:px-8" x-data="{ showModal: false }">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="mr-2 text-blue-600 fas fa-tasks"></i> Tugas untuk {{ $mataPelajaran->nama_mapel }} -
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

                <form action="{{ route('guru.tugas.store', [$mataPelajaran->slug, $kelas->slug]) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Judul Tugas</label>
                        <input type="text" name="judul" required class="w-full px-4 py-2 border rounded-md" />
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-md"></textarea>
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Tanggal Deadline</label>
                        <input type="date" name="tanggal_deadline" required class="px-4 py-2 border rounded-md" />
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Upload File (maks. 3 PDF/Word)</label>
                        <input type="file" name="files[]" accept=".pdf,.doc,.docx" multiple
                            class="w-full border rounded-md" />
                        <small class="text-sm text-gray-500">Maksimum 3 file, format PDF atau Word.</small>
                    </div>

                    <!-- Link YouTube -->
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Link YouTube (opsional)</label>
                        <input type="url" name="youtube_link" placeholder="https://youtube.com/..."
                            class="w-full px-4 py-2 border rounded-md" />
                    </div>

                    <!-- Buttons -->
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
                <i class="mr-2 text-indigo-600 fas fa-folder-open"></i> Tugas
            </h3>

            @forelse ($tugasList as $tugas)
                <a href="{{ route('guru.tugas.detail', ['mataPelajaran' => $mataPelajaran->slug, 'kelas' => $kelas->slug, 'tugas' => $tugas->slug]) }}"
                    class="block p-4 transition duration-200 bg-white border rounded shadow hover:shadow-md hover:border-blue-500 group">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-gray-700 group-hover:text-blue-600">{{ $tugas->judul }}
                        </h4>
                        <span class="text-sm text-gray-500">Deadline:
                            {{ $tugas->tanggal_deadline->format('d M Y') }}
                        </span>
                    </div>
                    <p class="mt-2 text-gray-600">{{ $tugas->deskripsi ?? '-' }}</p>
                </a>
            @empty
                <p class="text-gray-500">Belum ada tugas untuk kelas ini.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
