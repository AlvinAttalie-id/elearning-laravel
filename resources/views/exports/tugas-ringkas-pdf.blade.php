<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Tugas Ringkas</title>
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

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        table.data th {
            background-color: #f0f0f0;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="kop">
        <tr>
            <td style="width:80px; vertical-align:top;">
                <img src="{{ public_path('images/logo-header.png') }}" width="70" style="display:block; height:auto;">
            </td>
            <td style="text-align:center;">
                <h2 style="margin:0; font-size:18px;">SMK GARUDA MAHADHIKA</h2>
                <p style="margin:2px 0; font-size:12px; line-height:1.4;">
                    Jalan A. Yani Km 32,5 No. 24, Loktabat Selatan, Banjarbaru Selatan,<br>
                    Guntung Payung, Landasan Ulin, Kota Banjarbaru, Kalimantan Selatan · 11 km<br>
                    Telepon: +62 511 6749988
                </p>
            </td>
            <td style="width:80px;"></td>
        </tr>
    </table>
    <hr style="border:1px solid #000; margin:10px 0;">

    <!-- JUDUL -->
    <h2 class="judul">Laporan Tugas (Ringkas)</h2>

    <!-- TABEL -->
    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Judul</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $i => $tugas)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
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
