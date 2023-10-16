<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = 'feedback_categories';

        if (DB::table($tableName)->count() == 0)
        {
            $array =[
                [
                    'name'=> 'bug report'
                ],
                [
                    'name'=> 'feature request'
                ],
                [
                    'name'=> 'improvement'
                ]
                ];
            DB::table($tableName)->insert($array);
        }
    }
}
