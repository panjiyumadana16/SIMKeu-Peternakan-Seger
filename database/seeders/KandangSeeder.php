<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('kandangs')->insert([
            [
                'jenis_produk'  => 'Telur Ayam Tedu',
                'kandang'       => 'Kandang Ayam Tedu',
                'tgl_diambil'   => Carbon::now(),
                'stok'          => 500,
            ],
            [
                'jenis_produk'  => 'Telur Ayam Horen',
                'kandang'       => 'Kandang Ayam Horen',
                'tgl_diambil'   => Carbon::now(),
                'stok'          => 100,
            ]
        ]);
    }
}
