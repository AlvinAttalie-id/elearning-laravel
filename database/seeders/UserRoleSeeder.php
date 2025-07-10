<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Buat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $guruRole = Role::firstOrCreate(['name' => 'Guru']);
        $muridRole = Role::firstOrCreate(['name' => 'Murid']);

        // ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole($adminRole);

        // GURU
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => "guru{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            $user->assignRole($guruRole);

            Guru::create([
                'user_id' => $user->id,
                'nip' => 'NIP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'no_hp' => $faker->phoneNumber,
            ]);
        }

        // MURID (>120)
        for ($i = 1; $i <= 125; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => "murid{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            $user->assignRole($muridRole);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => 'NIS' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_lahir' => $faker->date('Y-m-d', '-10 years'),
                'alamat' => $faker->address,
                'kelas_id' => null,
            ]);
        }
    }
}
