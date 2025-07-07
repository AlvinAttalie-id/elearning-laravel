<x-app-layout>
    <div x-data="nilaiModal">

        <div class="space-y-6">

            {{-- Header --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Detail Tugas: {{ $tugas->judul }}
                </h2>
            </div>

            {{-- Info Tugas --}}
            <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                <p class="mb-2 text-sm text-gray-600"><strong>Mata Pelajaran:</strong> {{ $tugas->mapel->nama_mapel }}
                </p>
                <p class="mb-2 text-sm text-gray-600"><strong>Kelas:</strong> {{ $tugas->kelas->nama }}</p>
                <p class="mb-2 text-sm text-gray-600"><strong>Deskripsi:</strong> {{ $tugas->deskripsi ?? '-' }}</p>
                <p class="text-sm text-gray-600"><strong>Deadline:</strong>
                    {{ $tugas->tanggal_deadline->translatedFormat('d F Y H:i') }}</p>
            </div>

            {{-- Jawaban Siswa --}}
            <div class="flex items-center gap-3 mt-10">
                <div class="flex items-center justify-center w-10 h-10 text-green-600 bg-green-100 rounded-full">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Jawaban Siswa</h3>
            </div>

            @if ($siswaList->count())
                <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm rounded-xl">
                    <table class="w-full text-sm text-left table-auto">
                        <thead class="font-semibold text-gray-700 bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Jawaban</th>
                                <th class="px-4 py-2 border">File</th>
                                <th class="px-4 py-2 border">Waktu Kirim</th>
                                <th class="px-4 py-2 border">Nilai</th>
                                <th class="px-4 py-2 border">Feedback</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswaList as $i => $siswa)
                                @php
                                    $jawaban = $tugas->jawaban->firstWhere('siswa_id', $siswa->id);
                                    $nilai = $jawaban?->nilai;
                                @endphp
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $siswaList->firstItem() + $i }}</td>
                                    <td class="px-4 py-2 font-medium text-gray-800 border">{{ $siswa->user->name }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($jawaban)
                                            {{ Str::limit($jawaban->jawaban, 40) }}
                                        @else
                                            <span class="font-medium text-red-500">Belum menjawab</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        @if ($jawaban && $jawaban->file_path)
                                            <a href="{{ asset('storage/' . $jawaban->file_path) }}" target="_blank"
                                                class="text-sm text-blue-600 underline">Lihat File</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        @if ($jawaban)
                                            {{ \Carbon\Carbon::parse($jawaban->submitted_at)->translatedFormat('d M Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ $nilai?->nilai ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ $nilai?->feedback ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        @if ($jawaban && !$nilai)
                                            <button @click="showModal = true; selectedJawabanId = {{ $jawaban->id }}"
                                                class="px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                                Nilai
                                            </button>
                                        @elseif (!$jawaban)
                                            <span class="text-sm text-gray-400">-</span>
                                        @else
                                            <span class="font-semibold text-green-600">✓</span>
                                        @endif
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

        {{-- Modal Penilaian --}}
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

            <div x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                @click.away="showModal = false" class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h3 class="mb-4 text-lg font-bold text-gray-800">Beri Nilai</h3>
                <form method="POST" x-ref="formNilai" action="" @submit.prevent="submitForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nilai</label>
                        <input type="number" name="nilai" min="0" max="100" required
                            class="w-full px-3 py-2 mt-1 border rounded-md" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Feedback</label>
                        <textarea name="feedback" rows="2" class="w-full px-3 py-2 mt-1 border rounded-md"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showModal = false"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- Scripts --}}
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('nilaiModal', () => ({
                    showModal: false,
                    selectedJawabanId: null,
                    submitForm() {
                        const form = this.$refs.formNilai;
                        form.action = `/guru/jawaban/${this.selectedJawabanId}/nilai`;
                        form.submit();
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
