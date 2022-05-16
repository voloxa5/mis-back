<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictSexesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_sexes')->delete();

        DB::table('dict_sexes')->insert(
            [
                [
                    'value' => 'м'
                ],
                [
                    'value' => 'ж'
                ],
            ]
        );
    }
}
