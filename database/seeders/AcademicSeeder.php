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
    JawabanTugas,
    Nilai
};

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();   // utk feedback dummy
        /* --------------------------------------------------------------
         | 1.  KELAS
         * -------------------------------------------------------------*/
        $namaKelas = ['X‑1', 'XI‑1', 'XII‑1'];
        $kelas = collect($namaKelas)->map(fn($nama) => Kelas::create([
            'nama'          => $nama,
            'wali_kelas_id' => Guru::inRandomOrder()->first()->id,
        ]));

        /* --------------------------------------------------------------
         | 2.  TEMPATKAN SISWA KE KELAS
         * -------------------------------------------------------------*/
        $kelasIndex = 0;
        Siswa::whereNull('kelas_id')->get()->each(function ($siswa) use ($kelas, &$kelasIndex) {
            $siswa->update(['kelas_id' => $kelas[$kelasIndex]->id]);
            $kelasIndex = ($kelasIndex + 1) % $kelas->count();
        });

        /* --------------------------------------------------------------
         | 3.  MATA PELAJARAN
         * -------------------------------------------------------------*/
        $namaMapel = [
            'Matematika',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah'
        ];
        $mapel = collect($namaMapel)->map(fn($nama) => MataPelajaran::create([
            'nama_mapel' => $nama,
            'guru_id'    => Guru::inRandomOrder()->first()->id,
        ]));

        /* --------------------------------------------------------------
         | 4.  PIVOT KELAS‑MAPEL
         * -------------------------------------------------------------*/
        foreach ($kelas as $kls) {
            $kls->mataPelajaran()->sync($mapel->pluck('id'));
        }

        /* --------------------------------------------------------------
         | 5.  JADWAL PELAJARAN
         * -------------------------------------------------------------*/
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($kelas as $kls) {
            foreach ($mapel as $mpl) {
                JadwalPelajaran::create([
                    'kelas_id'    => $kls->id,
                    'mapel_id'    => $mpl->id,
                    'guru_id'     => $mpl->guru_id,
                    'hari'        => $hariList[array_rand($hariList)],
                    'jam_mulai'   => '08:00',
                    'jam_selesai' => '09:40',
                ]);
            }
        }

        /* --------------------------------------------------------------
         | 6.  TUGAS  &  7. JAWABAN + NILAI
         * -------------------------------------------------------------*/
        foreach ($kelas as $kls) {
            foreach ($mapel as $mpl) {
                for ($i = 1; $i <= 3; $i++) {
                    $tugas = Tugas::create([
                        'mapel_id'        => $mpl->id,
                        'kelas_id'        => $kls->id,
                        'judul' => "Tugas $i - {$mpl->nama_mapel} {$kls->nama}",
                        'deskripsi'       => "Kerjakan soal‑soal pada modul $i.",
                        'tanggal_deadline' => Carbon::now()->addDays(rand(7, 14)),
                    ]);

                    foreach ($kls->siswa as $sis) {
                        $jawaban = JawabanTugas::create([
                            'tugas_id'     => $tugas->id,
                            'siswa_id'     => $sis->id,
                            'jawaban'      => Str::random(40),
                            'file_path'    => null,
                            'submitted_at' => Carbon::now()->subDays(rand(0, 3)),
                        ]);

                        // baris nilai per jawaban
                        Nilai::create([
                            'siswa_id'          => $sis->id,
                            'mapel_id'          => $mpl->id,
                            'jawaban_tugas_id'  => $jawaban->id,
                            'nilai'             => rand(60, 100),
                            'feedback'          => $faker->sentence(),
                        ]);
                    }
                }
            }
        }

        /* --------------------------------------------------------------
         | 8.  (Optional) Nilai rekap per Mapel
         |     Jika ingin nilai akhir mata pelajaran,
         |     aktifkan blok di bawah ini.
         * -------------------------------------------------------------*/
        /*
        foreach ($kelas as $kls) {
            foreach ($kls->siswa as $sis) {
                foreach ($mapel as $mpl) {
                    Nilai::firstOrCreate(
                        [ // kunci unik rekap
                            'siswa_id' => $sis->id,
                            'mapel_id' => $mpl->id,
                            'jawaban_tugas_id' => null
                        ],
                        [
                            'nilai'    => rand(60,100),
                            'feedback' => 'Rata‑rata nilai tugas',
                        ]
                    );
                }
            }
        }
        */
    }
}
