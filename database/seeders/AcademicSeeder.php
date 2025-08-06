<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
use App\Models\{
    Guru,
    Siswa,
    Kelas,
    MataPelajaran,
    JadwalPelajaran,
    Tugas,
    TugasFile,
    JawabanTugas,
    Nilai
};

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Generate semua kelas
        $kelasList = collect();
        $angkatan = ['X', 'XI', 'XII'];
        $guruList = Guru::all();

        foreach ($angkatan as $tingkat) {
            for ($i = 1; $i <= 5; $i++) {
                $namaKelas = "$tingkat-$i";
                $wali = $guruList->random();
                $kelasList->push(
                    Kelas::create([
                        'nama' => $namaKelas,
                        'wali_kelas_id' => $wali->id,
                        'maksimal_siswa' => 40,
                    ])
                );
            }
        }

        // 2. Sebarkan siswa ke kelas
        $kelasIndex = 0;
        $kelasCount = $kelasList->count();

        Siswa::whereNull('kelas_id')->get()->each(function ($siswa) use ($kelasList, &$kelasIndex, $kelasCount) {
            $siswa->update(['kelas_id' => $kelasList[$kelasIndex]->id]);
            $kelasIndex = ($kelasIndex + 1) % $kelasCount;
        });

        // 3. Daftar mapel dan guru
        $mapelNames = [
            'Matematika',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Sosiologi',
            'Ekonomi',
            'Geografi'
        ];
        $mapelList = collect();

        foreach ($mapelNames as $namaMapel) {
            $guru = $guruList->random();
            $mapelList->push(
                MataPelajaran::create([
                    'nama_mapel' => $namaMapel,
                    'guru_id' => $guru->id,
                ])
            );
        }

        // 4. Setiap kelas mendapat 2–4 mapel
        foreach ($kelasList as $kelas) {
            $mapelKelas = $mapelList->random(rand(2, 4));
            $kelas->mataPelajaran()->sync($mapelKelas->pluck('id'));
        }

        // 5. Jadwal pelajaran
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($kelasList as $kelas) {
            foreach ($kelas->mataPelajaran as $mapel) {
                JadwalPelajaran::create([
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $mapel->id,
                    'guru_id' => $mapel->guru_id,
                    'hari' => $hariList[array_rand($hariList)],
                    'jam_mulai' => '08:00',
                    'jam_selesai' => '09:40',
                ]);
            }
        }

        // 6. Template jawaban dan feedback berdasarkan mapel
        $jawabanMapel = [
            'Matematika' => [
                'Saya telah menyelesaikan soal integral dan diferensial sesuai instruksi.',
                'Perhitungan aljabar saya sudah lengkap.',
                'Langkah pengerjaan soal trigonometri sudah saya tulis.'
            ],
            'Bahasa Inggris' => [
                'Saya menjawab pertanyaan reading comprehension dan membuat summary.',
                'Tugas grammar telah saya selesaikan dengan tense yang benar.',
                'Essay sudah saya tulis sesuai topik dan ketentuan.'
            ],
            'Fisika' => [
                'Percobaan hukum Newton telah saya rangkum dan analisis.',
                'Soal tentang gaya dan percepatan telah dikerjakan.',
                'Laporan praktikum listrik dinamis sudah saya buat.'
            ],
            'Kimia' => [
                'Saya menjawab semua soal reaksi kimia dan stoikiometri.',
                'Percobaan asam-basa sudah saya uraikan.',
                'Laporan titrasi telah saya kerjakan dengan lengkap.'
            ],
            'Biologi' => [
                'Saya menjelaskan proses fotosintesis dan respirasi sel.',
                'Tugas klasifikasi makhluk hidup sudah selesai.',
                'Struktur sel dan fungsinya sudah dijabarkan.'
            ],
            'Sejarah' => [
                'Saya membuat ringkasan tentang peristiwa Proklamasi Kemerdekaan.',
                'Tokoh pergerakan nasional sudah saya uraikan.',
                'Saya menjelaskan dampak penjajahan Belanda.'
            ],
            'Sosiologi' => [
                'Saya telah menjawab soal tentang perubahan sosial.',
                'Penjelasan tentang interaksi sosial sudah saya buat.',
                'Saya menulis esai mengenai konflik sosial di masyarakat.'
            ],
            'Ekonomi' => [
                'Saya menjelaskan hukum permintaan dan penawaran.',
                'Analisis inflasi dan pengangguran sudah saya buat.',
                'Tugas studi kasus tentang pasar telah saya selesaikan.'
            ],
            'Geografi' => [
                'Saya telah menyelesaikan peta wilayah iklim Indonesia.',
                'Penjelasan tentang fenomena geosfer sudah saya buat.',
                'Tugas tentang mitigasi bencana alam telah selesai.'
            ],
        ];

        $feedbackMapel = [
            'Matematika' => [
                'Perhitunganmu cukup akurat, lanjutkan!',
                'Tinjau kembali langkah ke-3 pada soal nomor 2.',
                'Kerja bagus, coba cek ulang hasil akhirmu.'
            ],
            'Bahasa Inggris' => [
                'Struktur kalimatmu sudah tepat.',
                'Grammar masih perlu ditingkatkan.',
                'Good job on the essay!'
            ],
            'Fisika' => [
                'Eksperimen kamu sudah sesuai.',
                'Coba perjelas rumus yang digunakan.',
                'Tinjau kesimpulanmu agar lebih tepat.'
            ],
            'Kimia' => [
                'Analisis titrasi cukup bagus.',
                'Reaksi kimia ditulis dengan benar.',
                'Perhatikan penulisan senyawa.'
            ],
            'Biologi' => [
                'Penjelasanmu tentang sel sangat baik.',
                'Kurangi kesalahan dalam terminologi.',
                'Bagus! Tetap semangat belajar biologi.'
            ],
            'Sejarah' => [
                'Narasi historismu kuat.',
                'Coba lengkapi sumber sejarah.',
                'Penulisan runut dan mudah dipahami.'
            ],
            'Sosiologi' => [
                'Tinjauan konflik sosial cukup mendalam.',
                'Perlu tambahan contoh konkret.',
                'Sudah tepat dan sesuai materi.'
            ],
            'Ekonomi' => [
                'Data ekonomi yang kamu pakai sudah tepat.',
                'Analisa pasar masih perlu diperdalam.',
                'Tugas kamu sudah sangat baik.'
            ],
            'Geografi' => [
                'Peta dan deskripsi sangat jelas.',
                'Perlu tambahan informasi geologi.',
                'Penjelasan mitigasi sudah baik.'
            ],
        ];

        // 7. Tugas dan jawaban siswa
        foreach ($kelasList as $kelas) {
            foreach ($kelas->mataPelajaran as $mapel) {
                for ($i = 1; $i <= 3; $i++) {
                    $tugas = Tugas::create([
                        'mapel_id' => $mapel->id,
                        'kelas_id' => $kelas->id,
                        'judul' => "Tugas $i - {$mapel->nama_mapel} {$kelas->nama}",
                        'deskripsi' => "Kerjakan soal modul ke-$i",
                        'tanggal_deadline' => Carbon::now()->addDays(rand(7, 14)),
                        'versi' => 1,
                    ]);

                    TugasFile::create([
                        'tugas_id' => $tugas->id,
                        'file_path' => 'tugas' . rand(1, 5) . '.pdf',
                    ]);

                    foreach ($kelas->siswa as $siswa) {
                        $mapelNama = $mapel->nama_mapel;

                        $jawaban = JawabanTugas::create([
                            'tugas_id' => $tugas->id,
                            'siswa_id' => $siswa->id,
                            'jawaban' => $faker->randomElement($jawabanMapel[$mapelNama] ?? ['Saya telah mengerjakan tugas sesuai instruksi.']),
                            'file_path' => null,
                            'submitted_at' => Carbon::now()->subDays(rand(0, 3)),
                        ]);

                        Nilai::create([
                            'siswa_id' => $siswa->id,
                            'mapel_id' => $mapel->id,
                            'jawaban_tugas_id' => $jawaban->id,
                            'nilai' => rand(60, 100),
                            'feedback' => $faker->randomElement($feedbackMapel[$mapelNama] ?? ['Sudah baik, terus belajar.']),
                        ]);
                    }
                }
            }
        }
    }
}
