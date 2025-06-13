<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Tugas Ringkas</title>
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
            margin-top: 14px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Laporan Tugas (Ringkas)</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Judul</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $i => $tugas)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $tugas->kelas->nama }}</td>
                    <td>{{ $tugas->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $tugas->judul }}</td>
                    <td>{{ $tugas->tanggal_deadline->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
