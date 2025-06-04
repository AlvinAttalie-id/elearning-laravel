<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $guruRole = Role::firstOrCreate(['name' => 'Guru']);
        $muridRole = Role::firstOrCreate(['name' => 'Murid']);

        // Buat 5 user guru beserta data di tabel guru
        for ($i = 1; $i <= 5; $i++) {
            $guruUser = User::create([
                'name' => "Guru {$i}",
                'email' => "guru{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            $guruUser->assignRole($guruRole);

            // Buat data guru terkait, tanpa kolom 'nama' karena ambil dari user
            Guru::create([
                'user_id' => $guruUser->id,
                'nip' => 'NIP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'no_hp' => '08123456789' . $i,
            ]);
        }

        // Buat 5 user murid beserta data di tabel siswa
        for ($i = 1; $i <= 5; $i++) {
            $muridUser = User::create([
                'name' => "Murid {$i}",
                'email' => "murid{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            $muridUser->assignRole($muridRole);

            // Buat data siswa terkait, kelas_id dikosongkan (null)
            Siswa::create([
                'user_id' => $muridUser->id,
                'nis' => 'NIS' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_lahir' => now()->subYears(10 + $i), // contoh tanggal lahir
                'alamat' => "Alamat Murid {$i}",
                'kelas_id' => null, // Kelas dikosongkan supaya tidak error FK
            ]);
        }

        // Tambah 1 Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole($adminRole);
    }
}
