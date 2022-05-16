<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('forms')->delete();

        DB::table('forms')->insert(
            [
                [
                    'name' => 'forma1',
                    'description' => 'Форма №1',
                    'content' => null,
                    'domain_id' => '1'
                ],
                [
                    'name' => 'forma2',
                    'description' => 'Форма №2',
                    'content' => null,
                    'domain_id' => '2'
                ],
                [
                    'name' => 'forma3',
                    'description' => 'Форма №3',
                    'content' => null,
                    'domain_id' => '3'
                ],
                [
                    'name' => 'forma4',
                    'description' => 'Форма №4',
                    'content' => null,
                    'domain_id' => '4'
                ],
            ]);
    }
}
