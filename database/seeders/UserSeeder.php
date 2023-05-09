<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username'  => 'admin',
                'password'  => Hash::make('admin'),
                'role_id'   => 1
            ],
            [
                'username'  => 'agentelur1',
                'password'  => Hash::make('agentelur1'),
                'role_id'   => 2
            ]
        ]);
    }
}
