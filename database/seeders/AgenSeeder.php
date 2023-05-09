<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('agens')->insert([
            [
                'user_id'   => 2,
                'nama'      => 'Agen Telur Berkah Jaya',
                'no_hp'     => '088000111222',
                'kota'      => 'Kediri',
                'alamat'    => 'Jl. Joyoboyo no. 99, Mojoroto'
            ]
        ]);
    }
}
