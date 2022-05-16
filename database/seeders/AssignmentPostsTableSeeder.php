<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssignmentPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignment_posts')->delete();

        DB::table('assignment_posts')->insert(
            [
                [
                    'appointment_date' => Carbon::parse('2017-07-11'),
                    'order_date' => Carbon::parse('2017-07-15'),
                    'order_number' => '121/11',
                    'post_id' => '1',

                ],
                [
                    'appointment_date' => Carbon::parse('2018-11-30'),
                    'order_date' => Carbon::parse('2018-09-17'),
                    'order_number' => '134/22',
                    'post_id' => '2',

                ],
                [
                    'appointment_date' => Carbon::parse('2019-09-14'),
                    'order_date' => Carbon::parse('2019-08-10'),
                    'order_number' => '188/34',
                    'post_id' => '3',

                ],
                [
                    'appointment_date' => Carbon::parse('2018-02-02'),
                    'order_date' => Carbon::parse('2019-03-16'),
                    'order_number' => '198/78',
                    'post_id' => '5',

                ],
                [
                    'appointment_date' => Carbon::parse('2019-05-14'),
                    'order_date' => Carbon::parse('2019-07-18'),
                    'order_number' => '158/78',
                    'post_id' => '4',

                ]

            ]
        );

    }

}
