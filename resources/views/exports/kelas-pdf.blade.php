<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Kelas – {{ $kelas->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin: 0;
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

        .section-title {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Data Kelas – {{ $kelas->nama }}</h2>

    <p><strong>Wali Kelas&nbsp;:</strong> {{ $kelas->waliKelas->user->name ?? '-' }}</p>

    {{-- Mata Pelajaran --}}
    <div class="section-title">Mata Pelajaran</div>
    <table>
        <thead>
            <tr>
                <th style="width:40%">Mata Pelajaran</th>
                <th>Guru Pengampu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas->mataPelajaran as $mapel)
                <tr>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>{{ $mapel->guru->user->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">– Tidak ada –</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Siswa --}}
    <div class="section-title">Daftar Siswa ({{ $kelas->siswa->count() }})</div>
    <table>
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas->siswa as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>{{ $siswa->nis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">– Tidak ada siswa –</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
