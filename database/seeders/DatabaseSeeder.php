<?php

namespace Database\Seeders;

// use DosenSeeder;
// use MahasiswaSeeder;
// use AdminSeeder;
// use PengajuanSeeder;
// use BimbinganSeeder;
// use SeminarSeeder;
// use NotifikasiSeeder;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FakultasSeeder::class,
            JurusanSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            AdminSeeder::class,
            PengajuanSeeder::class,
            BimbinganSeeder::class,
            SeminarSeeder::class,
            NotifikasiSeeder::class,
            PembimbingSeeder::class,
        ]);
    }
}
