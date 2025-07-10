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

        /* --------------------------------------------------------------
         | 1. KELAS (3 Kelas dengan wali_kelas dari Guru)
         * -------------------------------------------------------------*/
        $kelasNames = ['X-1', 'XI-1', 'XII-1'];
        $kelasList = collect();

        // Ambil semua guru dulu, karena model tidak soft delete
        $guruList = Guru::all();

        foreach ($kelasNames as $namaKelas) {
            $wali = $guruList->random(); // Ambil dari koleksi, bukan query langsung
            $kelasList->push(
                Kelas::create([
                    'nama' => $namaKelas,
                    'wali_kelas_id' => $wali->id,
                    'maksimal_siswa' => 40,
                ])
            );
        }

        /* --------------------------------------------------------------
         | 2. SISWA KE KELAS (Rotasi rata ke setiap kelas)
         * -------------------------------------------------------------*/
        $kelasIndex = 0;
        $kelasCount = $kelasList->count();

        Siswa::whereNull('kelas_id')->get()->each(function ($siswa) use ($kelasList, &$kelasIndex, $kelasCount) {
            $siswa->update(['kelas_id' => $kelasList[$kelasIndex]->id]);
            $kelasIndex = ($kelasIndex + 1) % $kelasCount;
        });

        /* --------------------------------------------------------------
         | 3. MATA PELAJARAN (Guru acak untuk setiap mapel)
         * -------------------------------------------------------------*/
        $mapelNames = [
            'Matematika',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Sosiologi',
            'Ekonomi',
            'Geografi',
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

        /* --------------------------------------------------------------
         | 4. KELAS <-> MAPEL (Setiap kelas dapat 2-4 mapel acak)
         * -------------------------------------------------------------*/
        foreach ($kelasList as $kelas) {
            $mapelKelas = $mapelList->random(rand(2, 4));
            $kelas->mataPelajaran()->sync($mapelKelas->pluck('id'));
        }

        /* --------------------------------------------------------------
         | 5. JADWAL PELAJARAN (Jam tetap, hari acak)
         * -------------------------------------------------------------*/
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

        /* --------------------------------------------------------------
         | 6. TUGAS, FILE TUGAS, JAWABAN, NILAI
         * -------------------------------------------------------------*/
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

                    // Lampirkan file PDF tugas (acak dari tugas1–5.pdf)
                    TugasFile::create([
                        'tugas_id' => $tugas->id,
                        'file_path' => 'tugas' . rand(1, 5) . '.pdf',
                    ]);

                    // Setiap siswa menjawab dan dinilai
                    foreach ($kelas->siswa as $siswa) {
                        $jawaban = JawabanTugas::create([
                            'tugas_id' => $tugas->id,
                            'siswa_id' => $siswa->id,
                            'jawaban' => Str::random(40),
                            'file_path' => null,
                            'submitted_at' => Carbon::now()->subDays(rand(0, 3)),
                        ]);

                        Nilai::create([
                            'siswa_id' => $siswa->id,
                            'mapel_id' => $mapel->id,
                            'jawaban_tugas_id' => $jawaban->id,
                            'nilai' => rand(60, 100),
                            'feedback' => $faker->sentence(),
                        ]);
                    }
                }
            }
        }
    }
}
