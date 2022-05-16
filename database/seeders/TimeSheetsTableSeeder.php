<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TimeSheetsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('time_sheets')->delete();

        DB::table('time_sheets')->insert([
            [
                'title' => 'Иванов И.А.',
                'day1' => 'В',
                'day2' => '12',
                'day3' => '8',
            ],
            [
                'title' => 'Сидоров В.Н.',
                'day1' => 'В',
                'day2' => '7',
                'day3' => '5',
            ],
            [
                'title' => 'Сумароков Д.К.',
                'day1' => '11',
                'day2' => '6',
                'day3' => '3',
            ],
            [
                'title' => 'Перцев В.Ю.',
                'day1' => 'В',
                'day2' => '7',
                'day3' => '7',
            ],
        ]);
    }
}
