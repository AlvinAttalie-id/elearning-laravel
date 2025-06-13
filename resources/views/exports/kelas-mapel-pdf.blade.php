<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Kelas & Mapel</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Laporan Kelas, Wali & Mata Pelajaran</h2>

    @foreach ($daftarKelas as $kelas)
        <h3>Kelas {{ $kelas->nama }}</h3>
        <p><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>

        <table>
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Pengampu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas->mataPelajaran as $i => $mapel)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $mapel->nama_mapel }}</td>
                        <td>{{ $mapel->guru->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">– Tidak ada mata pelajaran –</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
</body>

</html>
