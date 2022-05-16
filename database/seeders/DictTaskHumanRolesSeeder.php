<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictTaskHumanRolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_task_human_roles')->truncate();

        DB::table('dict_task_human_roles')->insert(
            [
                [
                    'value' => 'ОБЪЕКТ',
                ],
                [
                    'value' => 'СВЯЗЬ',
                ],
            ]);
    }
}
