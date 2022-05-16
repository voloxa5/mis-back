<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeederHumansTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_humans')->truncate();

        DB::table('task_humans')->insert(
            [
                [
                    'task_id' => '1',
                    'human_id' => '1',
                    'task_human_role_id' => 1,
                ],
                [
                    'task_id' => '1',
                    'human_id' => '2',
                    'task_human_role_id' => 2,
                ],
            ]);
    }
}
