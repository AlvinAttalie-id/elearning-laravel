<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Siswa – {{ $kelas->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
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
    <h2>Daftar Siswa – Kelas {{ $kelas->nama }}</h2>

    <p><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>NIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas->siswa as $i => $siswa)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>{{ $siswa->nis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">– Tidak ada siswa –</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
