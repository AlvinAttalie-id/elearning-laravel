<?php

// AcademicSeeder.php

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

        // 1. Generate semua kelas: X-1..5, XI-1..5, XII-1..5 (15 kelas)
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

        // 2. Sebarkan 525 siswa merata ke 15 kelas
        $kelasIndex = 0;
        $kelasCount = $kelasList->count();

        Siswa::whereNull('kelas_id')->get()->each(function ($siswa) use ($kelasList, &$kelasIndex, $kelasCount) {
            $siswa->update(['kelas_id' => $kelasList[$kelasIndex]->id]);
            $kelasIndex = ($kelasIndex + 1) % $kelasCount;
        });

        // 3. Mapel & guru
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

        // 4. Setiap kelas dapat 2–4 mapel
        foreach ($kelasList as $kelas) {
            $mapelKelas = $mapelList->random(rand(2, 4));
            $kelas->mataPelajaran()->sync($mapelKelas->pluck('id'));
        }

        // 5. Jadwal tetap
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

        // 6. Tugas dan jawaban siswa
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

                        $jawaban = JawabanTugas::create([
                            'tugas_id' => $tugas->id,
                            'siswa_id' => $siswa->id,
                            'jawaban' => Str::random(40),
                            'file_path' => null,
                            'submitted_at' => Carbon::now()->subDays(rand(0, 3)),
                        ]);

                        $feedbacks = [
                            'Good job!',
                            'Well done!',
                            'Coba lebih teliti lagi ya.',
                            'Jawaban kamu sudah bagus, tapi bisa dikembangkan.',
                            'Kerja bagus, pertahankan!',
                            'Jangan lupa baca materinya lagi.',
                            'Mantap, terus tingkatkan!',
                            'Sudah tepat, tapi perhatikan bagian akhir.',
                            'Perlu sedikit perbaikan.',
                            'Tugas dikerjakan dengan baik.',
                        ];

                        Nilai::create([

                            'siswa_id' => $siswa->id,
                            'mapel_id' => $mapel->id,
                            'jawaban_tugas_id' => $jawaban->id,
                            'nilai' => rand(60, 100),
                            'feedback' => $faker->randomElement($feedbacks),
                        ]);
                    }
                }
            }
        }
    }
}
