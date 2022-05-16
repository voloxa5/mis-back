<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HumansTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('humans')->truncate();

        DB::table('humans')->insert(
            [
                [
                    'name' => 'Иван',
                    'surname' => 'Иванов',
                    'patronymic' => 'Иванович',
                    'sex_id' => 1,
                ],
                [
                    'name' => 'Петр',
                    'surname' => 'Петров',
                    'patronymic' => 'Петрович',
                    'sex_id' => 1,
                ],
            ]);
    }
}
