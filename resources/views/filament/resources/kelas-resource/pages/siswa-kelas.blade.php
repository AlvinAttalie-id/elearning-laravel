<x-filament::page>
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-bold">Kelas: {{ $kelas->nama }}</h2>
            <p class="text-sm text-gray-600">Wali Kelas: {{ $kelas->waliKelas->user->name ?? '-' }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $index => $murid)
                        <tr class="border-b">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $murid->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $murid->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">Tidak ada siswa dalam kelas
                                ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
