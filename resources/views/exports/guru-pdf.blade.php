<!DOCTYPE html>
<html>

<head>
    <title>Daftar Guru</title>
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
    <h2>Daftar Guru</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Guru</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gurus as $guru)
                <tr>
                    <td>{{ $guru->user->name }}</td>
                    <td>{{ $guru->user->email }}</td>
                    <td>
                        {{ $guru->user->roles->pluck('name')->implode(', ') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
