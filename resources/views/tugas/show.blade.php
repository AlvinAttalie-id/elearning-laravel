<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <i data-lucide="clipboard-list" class="w-6 h-6 text-indigo-600"></i>
        <h2 class="text-2xl font-bold text-gray-800">Jawab Tugas - {{ $tugas->judul }}</h2>
    </div>

    <div class="py-6">
        <div class="max-w-3xl p-6 mx-auto space-y-4 bg-white border shadow rounded-xl">
            {{-- Info Tugas --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $tugas->judul }}</h3>
                <p class="mt-1 text-sm text-gray-700">{{ $tugas->deskripsi }}</p>
                <div class="mt-2 text-sm text-gray-500">
                    Deadline:
                    <span
                        class="{{ $tugas->tanggal_deadline->isPast() ? 'text-red-600 font-semibold' : 'text-green-600' }}">
                        {{ $tugas->tanggal_deadline->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- Jika Sudah Menjawab --}}
            @if ($jawaban)
                <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                    <h4 class="text-lg font-semibold text-green-700">Kamu sudah menjawab tugas ini.</h4>

                    <div class="mt-3 text-sm text-gray-800">
                        <p><strong>Jawaban:</strong> {{ $jawaban->jawaban ?: '-' }}</p>

                        @if ($jawaban->file_path)
                            <p class="mt-2">
                                <strong>File:</strong>
                                <a href="{{ asset('storage/' . $jawaban->file_path) }}" class="text-blue-600 underline"
                                    target="_blank">
                                    Download
                                </a>
                            </p>
                        @endif

                        <p class="mt-2 text-sm text-gray-500">
                            Dikirim pada: {{ \Carbon\Carbon::parse($jawaban->submitted_at)->format('d M Y H:i') }}
                        </p>

                        {{-- Tambahan: Nilai --}}
                        <div class="mt-4 text-sm">
                            <strong>Nilai:</strong>
                            @if ($nilai)
                                <span class="font-semibold text-emerald-700">{{ $nilai->nilai }}</span><br>
                                <strong>Feedback:</strong> {{ $nilai->feedback ?: '-' }}
                            @else
                                <span class="italic text-yellow-600">Belum dinilai</span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                {{-- Form Jawaban --}}
                <form action="{{ route('tugas.jawab', $tugas->id) }}" method="POST" enctype="multipart/form-data"
                    class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jawaban Teks (opsional)</label>
                        <textarea name="jawaban" rows="4"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Unggah File (opsional)</label>
                        <input type="file" name="file_path"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-indigo-600 rounded-xl shadow hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Tombol Floating Kembali --}}
    <div class="fixed z-40 bottom-8 left-8">
        <a href="{{ route('tugas.kelas-mapel', ['kelas' => $tugas->kelas_id, 'mapel' => $tugas->mapel_id]) }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>
</x-app-layout>
