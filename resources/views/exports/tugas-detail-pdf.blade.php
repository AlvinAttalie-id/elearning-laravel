<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Tugas – {{ $kelas->nama }}</title>
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

        h3 {
            margin: 16px 0 4px;
            font-size: 14px;
        }

        p {
            margin: 4px 0;
        }

        table.jawaban {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        table.jawaban th,
        table.jawaban td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        table.jawaban th {
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
    <h2 class="judul">Laporan Tugas – Kelas {{ $kelas->nama }}</h2>

    @forelse ($tasks as $index => $tugas)
        <h3>{{ $index + 1 }}. {{ $tugas->judul }}</h3>
        <p><strong>Mata Pelajaran:</strong> {{ $tugas->mapel->nama_mapel ?? '-' }}<br>
            <strong>Deadline:</strong> {{ $tugas->tanggal_deadline->format('d M Y') }}
        </p>
        <p><strong>Deskripsi:</strong><br>{{ $tugas->deskripsi ?? '-' }}</p>

        <table class="jawaban">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Nama Siswa</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas->jawaban as $i => $jawab)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $jawab->siswa->user->name ?? '-' }}</td>
                        <td>{{ $jawab->jawaban }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">Belum ada jawaban.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        <p style="margin-top:12px;">Tidak ada tugas di kelas ini.</p>
    @endforelse
</body>

</html>
