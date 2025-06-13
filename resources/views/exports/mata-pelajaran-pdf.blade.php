<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daftar Mata Pelajaran</title>
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
    <h2>Daftar Mata Pelajaran</h2>

    <table>
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th>Nama Mapel</th>
                <th>Guru Pengampu</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mapel as $i => $m)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $m->nama_mapel }}</td>
                    <td>{{ $m->guru->user->name ?? '-' }}</td>
                    <td>{{ $m->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
