<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AgenSeeder::class,
            KategoriSeeder::class,
            KandangSeeder::class,
            StokSeeder::class,
            OngkirKotaSeeder::class,
        ]);
    }
}
