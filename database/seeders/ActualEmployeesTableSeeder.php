<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActualEmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actual_employees')->delete();

        DB::table('actual_employees')->insert(
            [
                [
                    'name' => 'Андрей',
                    'surname' => 'Иванов',
                    'patronymic' => 'Иванович',
                    'callsign' => '152',
                    'post_id' => '1',
                    'rank_id' => '1',
                    'working_id' => '1',
                    'employee_id' => '1'
                ],
                [
                    'name' => 'Елена',
                    'surname' => 'Степанова',
                    'patronymic' => 'Андреевна',
                    'callsign' => '22',
                    'post_id' => '2',
                    'rank_id' => '1',
                    'working_id' => '1',
                    'employee_id' => '4'
                ],
                [
                    'name' => 'Иван',
                    'surname' => 'Кудрин',
                    'patronymic' => 'Сергеевич',
                    'callsign' => '12',
                    'post_id' => '3',
                    'rank_id' => '3',
                    'working_id' => '1',
                    'employee_id' => '3'
                ],
                [
                    'name' => 'Влад',
                    'surname' => 'Сергеев',
                    'patronymic' => 'Алексеевич',
                    'callsign' => '44',
                    'post_id' => '4',
                    'rank_id' => '4',
                    'working_id' => '1',
                    'employee_id' => '3'
                ],
                [
                    'name' => 'Степан',
                    'surname' => 'Иванов',
                    'patronymic' => 'Васильевич',
                    'callsign' => '122',
                    'post_id' => '5',
                    'rank_id' => '5',
                    'working_id' => '2',
                    'employee_id' => '2'
                ],
            ]
        );
    }
}
