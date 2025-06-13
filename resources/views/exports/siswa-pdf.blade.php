<!DOCTYPE html>
<html>

<head>
    <title>Daftar Siswa</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Daftar Siswa</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NIS</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
