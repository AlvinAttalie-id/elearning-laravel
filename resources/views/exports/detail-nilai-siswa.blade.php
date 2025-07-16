<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Nilai – {{ $siswa->user->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .info {
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <h2>Detail Nilai – {{ $siswa->user->name }}</h2>
    <p>Kelas: {{ $siswa->kelas->nama ?? '-' }}</p>

    @foreach ($jawaban as $mapel => $listJawaban)
        <h3>{{ $mapel }}</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Tugas</th>
                    <th>Nilai</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listJawaban as $i => $j)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $j['tugas']['judul'] }}</td>
                        <td>{{ $j['nilai']['nilai'] ?? '-' }}</td>
                        <td>{{ $j['nilai']['feedback'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="info">
            Rata-rata: <strong>{{ $rataNilaiPerMapel[$mapel] }}</strong> –
            Nilai Huruf: <strong>{{ $nilaiHurufPerMapel[$mapel] }}</strong>
        </p>
    @endforeach

    <hr style="margin: 20px 0">

    <p>
        Total Tugas: {{ $jumlahTugas }} <br>
        Total Nilai: {{ $totalNilai }} <br>
        Rata-rata: <strong>{{ number_format($rataNilai, 1) }}</strong> –
        Nilai Huruf Akhir: <strong>{{ $nilaiHurufAkhir }}</strong>
    </p>
</body>

</html>
