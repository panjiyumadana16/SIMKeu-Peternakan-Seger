<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OngkirKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ongkir_kotas')->insert([
            [
                'nama_kota'     => 'Kab. Kediri',
                'biaya_ongkir'  => 5000,
            ],
            [
                'nama_kota'     => 'Kota Kediri',
                'biaya_ongkir'  => 5000,
            ],
            [
                'nama_kota'     => 'Kab. Blitar',
                'biaya_ongkir'  => 10000,
            ],
            [
                'nama_kota'     => 'Kab. Tulungagung',
                'biaya_ongkir'  => 10000,
            ],
            [
                'nama_kota'     => 'Kab. Malang',
                'biaya_ongkir'  => 15000,
            ],
            [
                'nama_kota'     => 'Kota Malang',
                'biaya_ongkir'  => 15000,
            ],
        ]);
    }
}
