<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stoks')->insert([
            [
                'kandang_id'    => 1,
                'kategori_id'   => 1,
                'tgl_diambil'   => Carbon::now(),
                'jml_stok'      => 650,
            ],
            [
                'kandang_id'    => 2,
                'kategori_id'   => 2,
                'tgl_diambil'   => Carbon::now(),
                'jml_stok'      => 500,
            ],
        ]);
    }
}
