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
                'kandang'       => 'Kandang Ayam Tedu',
                'jml_ayam'      => 200,
            ],
            [
                'kandang'       => 'Kandang Ayam Horen',
                'jml_ayam'      => 250,
            ]
        ]);
    }
}
