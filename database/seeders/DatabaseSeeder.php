<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder dalam urutan yang tepat
        $this->call([
            RoleSeeder::class,
            UserRoleSeeder::class,
            AcademicSeeder::class,
        ]);
    }
}
