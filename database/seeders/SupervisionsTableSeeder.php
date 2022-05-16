<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupervisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supervisions')->delete();

        DB::table('supervisions')->insert(
            [
                [
                    'task_id' => '1',
                    'number' => '1',
                    'start_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'end_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'content' => 'С/Н велось по месту ....',

                ],
                [
                    'task_id' => '2',
                    'number' => '1',
                    'start_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'end_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'content' => 'Обьект вышел из ....',

                ],
                [
                    'task_id' => '1',
                    'number' => '2',
                    'start_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'end_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'content' => 'Наблюдаемый зашел....',

                ],
                [
                    'task_id' => '3',
                    'number' => '1',
                    'start_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'end_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'content' => 'После чего был....',

                ],
                [
                    'task_id' => '1',
                    'number' => '3',
                    'start_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'end_date' => \Carbon\Carbon::create(2019, 11, 22),
                    'content' => 'С/Н было прервано ....',

                ],
            ]
        );

    }
}

