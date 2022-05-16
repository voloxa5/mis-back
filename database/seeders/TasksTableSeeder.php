<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
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
                    'alias_name' => 'Андрей',
                    'number' => '13.19',
                    'memorandum' => 'кражи из магазинов',
                    'initiator_full_name' => 'Иванов И.И.',
                    'initiator_phone' => '+79870000000',
                    'reg_date' => Carbon::parse('2019-07-11'),
                    'day_count' => '10',
                    'ratifying_dob' => 'Иванов А.Г.',
                    'ratifying_post_id' => 1,
                    'ratifying_rank_id' => 1,
                ],
                [
                    'alias_name' => 'Влад',
                    'number' => '16.19',
                    'memorandum' => 'грабежи в ночное время суток',
                    'initiator_full_name' => 'Сидоров И.И.',
                    'initiator_phone' => '+79990000022',
                    'reg_date' => Carbon::parse('2019-07-11'),
                    'day_count' => '5',
                    'ratifying_dob' => 'Иванов А.Г.',
                    'ratifying_post_id' => 1,
                    'ratifying_rank_id' => 1,
                ],
                [
                    'alias_name' => 'Вася',
                    'number' => '15.19',
                    'memorandum' => 'угоны а/м',
                    'initiator_full_name' => 'Андреев И.В.',
                    'initiator_phone' => '+79176557667',
                    'reg_date' => Carbon::parse('2019-07-11'),
                    'day_count' => '7',
                    'ratifying_dob' => 'Степанов С.В.',
                    'ratifying_post_id' => 1,
                    'ratifying_rank_id' => 1,
                ],
                [
                    'alias_name' => 'Семен',
                    'number' => '19.19',
                    'memorandum' => 'вымогательства у ип',
                    'initiator_full_name' => 'Васечкин П.М.',
                    'initiator_phone' => '+79064774567',
                    'reg_date' => Carbon::parse('2019-07-11'),
                    'day_count' => '13',
                    'ratifying_dob' => 'Крепков Л.К.',
                    'ratifying_post_id' => 1,
                    'ratifying_rank_id' => 1,
                ],
                [
                    'alias_name' => 'Антон',
                    'number' => '12.19',
                    'memorandum' => 'мошейничество',
                    'initiator_full_name' => 'Антонов Р.С.',
                    'initiator_phone' => '+79861110202',
                    'reg_date' => Carbon::parse('2019-07-11'),
                    'day_count' => '6',
                    'ratifying_dob' => 'Филеев Ф.Х.',
                    'ratifying_post_id' => 1,
                    'ratifying_rank_id' => 1,
                ],
            ]
        );

    }
}
