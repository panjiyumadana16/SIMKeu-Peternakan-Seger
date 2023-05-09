<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('kategories')->insert([
            [
                'nama_kategori' => 'Telur Putih'
            ],
            [
                'nama_kategori' => 'Telur Merah'
            ],
        ]);
    }
}
