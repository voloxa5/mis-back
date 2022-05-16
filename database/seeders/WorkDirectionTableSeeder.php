<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WorkDirectionTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();

        DB::table('tasks')->insert(
            [
                [
                    'value' => '1 линия'
                ],
                [
                    'value' => '2 линия'
                ],
            ]
        );
    }
}
