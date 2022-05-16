<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssignmentRanksTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignment_ranks')->delete();

        DB::table('assignment_ranks')->insert(
            [
                [
                    'assignment_date' => Carbon::parse('2018-07-11'),
                    'order_date' => Carbon::parse('2019-07-15'),
                    'order_number' => '800/19',
                    'rank_id' => '1',

                ],
                [
                    'assignment_date' => Carbon::parse('2019-11-30'),
                    'order_date' => Carbon::parse('2019-09-17'),
                    'order_number' => '256/18',
                    'rank_id' => '2',

                ],
                [
                    'assignment_date' => Carbon::parse('2019-09-14'),
                    'order_date' => Carbon::parse('2019-08-10'),
                    'order_number' => '177/34',
                    'rank_id' => '1',

                ],
                [
                    'assignment_date' => Carbon::parse('2019-02-02'),
                    'order_date' => Carbon::parse('2019-03-16'),
                    'order_number' => '118/18',
                    'rank_id' => '2',

                ],
                [
                    'assignment_date' => Carbon::parse('2018-05-14'),
                    'order_date' => Carbon::parse('2019-07-18'),
                    'order_number' => '148/98',
                    'rank_id' => '4',

                ]

            ]
        );

    }

}

