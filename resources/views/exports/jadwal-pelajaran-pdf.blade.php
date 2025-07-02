<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Pelajaran - {{ $kelas->nama }}</title>
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

        table.jadwal {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.jadwal th,
        table.jadwal td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            font-size: 12px;
        }

        table.jadwal th {
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
    <hr style="border:1px solid #000; margin:10px 0;">

    <!-- JUDUL -->
    <h2 class="judul">Jadwal Pelajaran - Kelas {{ $kelas->nama }}</h2>

    <!-- TABEL JADWAL -->
    <table class="jadwal">
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
