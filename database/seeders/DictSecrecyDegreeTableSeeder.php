<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictSecrecyDegreeTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_secrecy_degrees')->delete();

        DB::table('dict_secrecy_degrees')->insert(
            [
                [
                    'value' => 'с'
                ],
                [
                    'value' => 'сс'
                ],
                [
                    'value' => 'дсп'
                ],
            ]
        );
    }
}
