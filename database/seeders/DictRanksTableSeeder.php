<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictRanksTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_ranks')->delete();

        DB::table('dict_ranks')->insert(
            [
                [
                    'value' => 'сержант'
                ],
                [
                    'value' => 'майор'
                ],
                [
                    'value' => 'капитан'
                ],
                [
                    'value' => 'старший лейтенант'
                ],
                [
                    'value' => 'подполковник'
                ],


            ]
        );

    }

}
