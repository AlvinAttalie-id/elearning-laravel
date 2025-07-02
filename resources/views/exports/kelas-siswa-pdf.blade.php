<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Siswa – {{ $kelas->nama }}</title>
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

        p {
            margin: 4px 0;
            font-size: 12px;
        }

        table.siswa {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.siswa th,
        table.siswa td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        table.siswa th {
            background-color: #f0f0f0;
            text-align: center;
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
    <hr style="border:1px solid #000; margin:10px 0;">

    <!-- JUDUL -->
    <h2 class="judul">Daftar Siswa – Kelas {{ $kelas->nama }}</h2>

    <!-- INFO WALI -->
    <p><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>

    <!-- TABEL SISWA -->
    <table class="siswa">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>NIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas->siswa as $i => $siswa)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>{{ $siswa->nis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">– Tidak ada siswa –</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
