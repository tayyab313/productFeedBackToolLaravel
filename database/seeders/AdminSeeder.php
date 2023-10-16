<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tableName = 'admins';

        if (DB::table($tableName)->count() == 0)
        {
            DB::table($tableName)->insert([
                'name'      => 'Super Admin',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('11223344'),
            ]);
        }

    }
}
