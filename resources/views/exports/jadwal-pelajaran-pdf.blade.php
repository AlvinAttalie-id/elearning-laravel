<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Jadwal Pelajaran - {{ $kelas->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Jadwal Pelajaran - Kelas {{ $kelas->nama }}</h2>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengampu</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwal as $item)
                <tr>
                    <td>{{ $item->hari }}</td>
                    <td>{{ $item->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>{{ $item->guru->user->name ?? '-' }}</td>
                    <td>{{ $item->jam_mulai }}</td>
                    <td>{{ $item->jam_selesai }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada jadwal tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
