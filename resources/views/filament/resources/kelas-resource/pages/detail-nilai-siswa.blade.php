<x-filament::page>
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <div
                class="flex items-center justify-center w-12 h-12 text-green-600 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-400">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Detail Nilai: {{ $siswa->user->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Kelas: {{ $siswa->kelas->nama ?? '-' }}
                </p>
            </div>
        </div>

        @foreach ($jawaban as $mapel => $listJawaban)
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">{{ $mapel }}</h3>

                <div class="p-6 bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
                    <table class="w-full text-sm table-auto">
                        <thead class="font-semibold text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Judul Tugas</th>
                                <th class="px-4 py-2 border">Nilai</th>
                                <th class="px-4 py-2 border">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listJawaban as $i => $j)
                                <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $j['tugas']['judul'] }}</td>
                                    <td class="px-4 py-2 border">{{ $j['nilai']['nilai'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $j['nilai']['feedback'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 text-sm text-right text-gray-600 dark:text-gray-300">
                        Rata-rata nilai <strong>{{ $mapel }}</strong>:
                        <span class="font-semibold text-indigo-700 dark:text-indigo-400">
                            {{ $rataNilaiPerMapel[$mapel] }}
                        </span>
                        <span
                            class="inline-block px-2 py-0.5 ml-2 text-xs font-bold text-white bg-indigo-500 rounded-full">
                            {{ $nilaiHurufPerMapel[$mapel] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach

        <div
            class="p-4 mt-6 text-sm border-l-4 border-indigo-500 rounded-md bg-indigo-50 dark:bg-gray-800 dark:border-indigo-700">
            Total Tugas: <strong>{{ $jumlahTugas }}</strong><br>
            Total Nilai: <strong>{{ $totalNilai }}</strong><br>
            Nilai Akhir (rata-rata):
            <strong class="text-lg text-indigo-700 dark:text-indigo-400">
                {{ number_format($rataNilai, 1) }}
            </strong>
            <span class="inline-block px-2 py-0.5 ml-2 text-sm font-bold text-white bg-indigo-600 rounded-full">
                {{ $nilaiHurufAkhir }}
            </span>
        </div>
    </div>
</x-filament::page>
