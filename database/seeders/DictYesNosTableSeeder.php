<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictYesNosTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_yes_nos')->delete();

        DB::table('dict_yes_nos')->insert(
            [
                [
                    'value' => 'да'
                ],
                [
                    'value' => 'нет'
                ]
            ]
        );
    }
}
