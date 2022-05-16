<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete();

        DB::table('employees')->insert(
            [
                [
                    'user_id' => 1,
                    'name' => 'Андрей',
                    'surname' => 'Иванов',
                    'patronymic' => 'Иванович',
                    'callsign' => '152',
                    'post_id' => '1',
                    'rank_id' => '2',
                    'working_id' => '1',
                    'sex_id' => '1',
                    'dob' => Carbon::parse('1989-07-11'),
                    'note' => '',
                ],
                [
                    'user_id' => 2,
                    'name' => 'Елена',
                    'surname' => 'Степанова',
                    'patronymic' => 'Андреевна',
                    'callsign' => '22',
                    'post_id' => '2',
                    'rank_id' => '1',
                    'working_id' => '1',
                    'sex_id' => '2',
                    'dob' => Carbon::parse('2001-05-11'),
                    'note' => '',
                ],
                [
                    'user_id' => 3,
                    'name' => 'Иван',
                    'surname' => 'Кудрин',
                    'patronymic' => 'Сергеевич',
                    'callsign' => '12',
                    'post_id' => '3',
                    'rank_id' => '3',
                    'working_id' => '1',
                    'sex_id' => '1',
                    'dob' => Carbon::parse('1999-01-17'),
                    'note' => '',
                ],
                [
                    'user_id' => 4,
                    'name' => 'Влад',
                    'surname' => 'Сергеев',
                    'patronymic' => 'Алексеевич',
                    'callsign' => '44',
                    'post_id' => '4',
                    'rank_id' => '4',
                    'working_id' => '1',
                    'sex_id' => '1',
                    'dob' => Carbon::parse('2000-03-11'),
                    'note' => '',
                ],
                [
                    'user_id' => 5,
                    'name' => 'Степан',
                    'surname' => 'Иванов',
                    'patronymic' => 'Васильевич',
                    'callsign' => '122',
                    'post_id' => '5',
                    'rank_id' => '5',
                    'working_id' => '2',
                    'sex_id' => '1',
                    'dob' => Carbon::parse('1965-06-15'),
                    'note' => '',
                ],
            ]
        );
    }
}
