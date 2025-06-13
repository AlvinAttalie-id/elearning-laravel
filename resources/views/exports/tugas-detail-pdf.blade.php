<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Tugas – {{ $kelas->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        h3 {
            margin: 14px 0 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #f0f0f0;
        }

        .mb-2 {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <h2>Laporan Tugas – Kelas {{ $kelas->nama }}</h2>

    @forelse ($tasks as $index => $tugas)
        <h3>{{ $index + 1 }}. {{ $tugas->judul }}</h3>

        <p class="mb-2"><strong>Mata Pelajaran:</strong> {{ $tugas->mapel->nama_mapel ?? '-' }}<br>
            <strong>Deadline:</strong> {{ $tugas->tanggal_deadline->format('d M Y') }}
        </p>

        <p><strong>Deskripsi:</strong><br>{{ $tugas->deskripsi ?? '-' }}</p>

        {{-- Jawaban siswa --}}
        <table>
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Nama Siswa</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas->jawaban as $i => $jawab)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $jawab->siswa->user->name ?? '-' }}</td>
                        <td>{{ $jawab->jawaban }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada jawaban.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @empty
        <p>Tidak ada tugas di kelas ini.</p>
    @endforelse
</body>

</html>
