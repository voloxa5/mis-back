<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->delete();

        DB::table('shifts')->insert(
            [
                [
                    'number' => '1',
                    'start_time' => \Carbon\Carbon::create(2019, 11, 22, 15, 00),
                    'end_time' => \Carbon\Carbon::create(2019, 11, 22, 19, 00),
                    'was_observed_id' => '1',
                    'supervision_condition' => 'С/н велось по месту жительства',
                    'supervision_id' => '1'
                ],
                [
                    'number' => '2',
                    'start_time' => \Carbon\Carbon::create(2019, 11, 22, 19, 00),
                    'end_time' => \Carbon\Carbon::create(2019, 11, 22, 23, 00),
                    'was_observed_id' => '1',
                    'supervision_condition' => 'С/н велось по месту жительства',
                    'supervision_id' => '1'
                ],
                [
                    'number' => '3',
                    'start_time' => \Carbon\Carbon::create(2019, 11, 22, 23, 00),
                    'end_time' => \Carbon\Carbon::create(2019, 11, 22, 9, 00),
                    'was_observed_id' => '2',
                    'supervision_condition' => 'С/н велось по месту жительства',
                    'supervision_id' => '1'
                ],
                [
                    'number' => '4',
                    'start_time' => \Carbon\Carbon::create(2019, 11, 22, 13, 00),
                    'end_time' => \Carbon\Carbon::create(2019, 11, 22, 21, 00),
                    'was_observed_id' => '2',
                    'supervision_condition' => 'С/н велось по месту вероятного появления',
                    'supervision_id' => '2'
                ],
                [
                    'number' => '5',
                    'start_time' => \Carbon\Carbon::create(2019, 11, 22, 11, 00),
                    'end_time' => \Carbon\Carbon::create(2019, 11, 22, 22, 00),
                    'was_observed_id' => '1',
                    'supervision_condition' => 'С/н велось по месту вероятного появления',
                    'supervision_id' => '3'
                ],

            ]
        );

    }
}
