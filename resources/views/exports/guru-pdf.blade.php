<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Guru</title>
    <style>
        @page {
            size: A4;
            margin: 25px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table.kop {
            width: 100%;
            border-collapse: collapse;
        }

        h2.judul {
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
        }

        table.daftar-guru {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.daftar-guru th,
        table.daftar-guru td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            text-align: center;
        }

        table.daftar-guru th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="kop">
        <tr>
            <!-- Logo kiri -->
            <td style="width:80px; vertical-align:top;">
                <img src="{{ public_path('images/logo-header.png') }}" width="70" style="height:auto; display:block;">
            </td>

            <!-- Teks tengah -->
            <td style="text-align:center;">
                <h2 style="margin:0; font-size:18px;">SMK GARUDA MAHADHIKA</h2>
                <p style="margin:2px 0; font-size:12px; line-height:1.4;">
                    Jalan A. Yani Km 32,5 No. 24, Loktabat Selatan, Banjarbaru Selatan,<br>
                    Guntung Payung, Landasan Ulin, Kota Banjarbaru, Kalimantan Selatan · 11 km<br>
                    Telepon: +62 511 6749988
                </p>
            </td>

            <!-- Dummy kolom kanan -->
            <td style="width:80px;"></td>
        </tr>
    </table>

    <!-- Garis pemisah -->
    <hr style="border:1px solid #000; margin: 10px 0;">

    <!-- JUDUL -->
    <h2 class="judul">Daftar Guru</h2>

    <!-- TABEL GURU -->
    <table class="daftar-guru">
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
                    <td>{{ $guru->user->roles->pluck('name')->implode(', ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
