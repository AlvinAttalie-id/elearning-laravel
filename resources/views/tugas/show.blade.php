<x-app-layout>
    <div class="max-w-4xl px-4 py-10 mx-auto space-y-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="clipboard-list" class="w-6 h-6 text-indigo-600"></i>
            <h2 class="text-2xl font-bold text-gray-800">Jawab Tugas - {{ $tugas->judul }}</h2>
        </div>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-md">
                <ul class="space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Info Card --}}
        <div class="p-6 space-y-6 bg-white border shadow rounded-xl">
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $tugas->judul }}</h3>
                <p class="mt-1 text-sm text-gray-700">{{ $tugas->deskripsi }}</p>

                {{-- Video --}}
                @if ($tugas->link_video)
                    @php
                        function getYoutubeEmbedUrl($url)
                        {
                            if (Str::contains($url, 'youtu.be')) {
                                return 'https://www.youtube.com/embed/' . Str::after($url, 'youtu.be/');
                            }
                            if (Str::contains($url, 'youtube.com/watch')) {
                                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                return 'https://www.youtube.com/embed/' . ($query['v'] ?? '');
                            }
                            return $url;
                        }
                    @endphp
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-gray-700">Video Penjelasan:</h4>
                        <div class="mt-2 aspect-w-16 aspect-h-9">
                            <iframe class="w-full h-64 rounded-lg" src="{{ getYoutubeEmbedUrl($tugas->link_video) }}"
                                frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif

                {{-- File Tugas --}}
                @if ($tugas->files->count())
                    <div class="mt-4">
                        <h4 class="mb-2 text-sm font-semibold text-gray-700">File Tugas:</h4>
                        <div class="space-y-2">
                            @foreach ($tugas->files as $file)
                                <div class="flex items-center justify-between p-3 border rounded-md bg-gray-50">
                                    <span class="text-sm text-gray-800 truncate">
                                        📎 {{ basename($file->file_path) }}
                                    </span>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                        class="px-3 py-1.5 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Deadline --}}
                <div class="mt-4 text-sm text-gray-500">
                    Deadline:
                    <span
                        class="{{ $tugas->tanggal_deadline->isPast() ? 'text-red-600 font-semibold' : 'text-green-600' }}">
                        {{ $tugas->tanggal_deadline->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- Jika Sudah Menjawab --}}
            @if ($jawaban)
                <div class="p-4 space-y-2 border border-green-200 bg-green-50 rounded-xl">
                    <h4 class="text-base font-semibold text-green-700">Kamu sudah menjawab tugas ini</h4>

                    <div class="text-sm text-gray-800">
                        <p><strong>Jawaban Teks:</strong> {{ $jawaban->jawaban ?: '-' }}</p>

                        @if ($jawaban->file_path)
                            <p class="mt-2">
                                <strong>File Jawaban:</strong>
                                <a href="{{ asset('storage/' . $jawaban->file_path) }}" class="text-blue-600 underline"
                                    target="_blank">
                                    Download File
                                </a>
                            </p>
                        @endif

                        <p class="mt-2 text-gray-500">
                            Dikirim pada: {{ \Carbon\Carbon::parse($jawaban->submitted_at)->format('d M Y H:i') }}
                        </p>

                        {{-- Nilai --}}
                        <div class="mt-2">
                            <strong>Nilai:</strong>
                            @if ($nilai)
                                <span class="font-semibold text-emerald-700">{{ $nilai->nilai }}</span>
                                <br><strong>Feedback:</strong> {{ $nilai->feedback ?: '-' }}
                            @else
                                <span class="italic text-yellow-600">Belum dinilai</span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                {{-- Form Jawaban --}}
                <form method="POST" action="{{ route('tugas.jawab', $tugas->slug) }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Teks Jawaban --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jawaban Teks</label>
                        <textarea name="jawaban" rows="4" required
                            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    {{-- Upload File --}}
                    <div x-data="{ fileName: '' }">
                        <label for="file_path" class="block text-sm font-medium text-gray-700">
                            Unggah File <span class="text-red-500">*</span>
                        </label>

                        <div class="relative mt-1">
                            <input type="file" name="file_path" id="file_path" accept=".pdf,.doc,.docx" required
                                @change="fileName = $event.target.files[0]?.name || ''"
                                class="block w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 focus:ring-indigo-500 focus:border-indigo-500">

                            <template x-if="fileName">
                                <p class="mt-2 text-xs text-gray-500">Terpilih: <strong x-text="fileName"></strong></p>
                            </template>
                        </div>

                        <p class="mt-1 text-xs text-gray-500">
                            Format yang diizinkan: PDF, DOC, atau DOCX (maks 2MB)
                        </p>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kirim Jawaban
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Floating Kembali --}}
    <div class="fixed z-40 bottom-8 left-8">
        <a href="{{ route('tugas.kelas-mapel', [
            'kelas' => $tugas->kelas->slug,
            'mataPelajaran' => $tugas->mataPelajaran->slug,
        ]) }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-full shadow-lg hover:bg-gray-800">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
    </div>
</x-app-layout>
