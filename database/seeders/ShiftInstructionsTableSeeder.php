<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShiftInstructionsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift_instructions')->delete();

        DB::table('shift_instructions')->insert(
            [
                [
                    'actual_employee_id' => '1',
                    'shift_id' => '1'
                ],
                [
                    'actual_employee_id' => '2',
                    'shift_id' => '1'
                ],
                [
                    'actual_employee_id' => '2',
                    'shift_id' => '2'
                ],
                [
                    'actual_employee_id' => '5',
                    'shift_id' => '2'
                ],
                [
                    'actual_employee_id' => '3',
                    'shift_id' => '3'
                ],
                [
                    'actual_employee_id' => '4',
                    'shift_id' => '4'
                ],
                [
                    'actual_employee_id' => '5',
                    'shift_id' => '5'
                ],

            ]
        );

    }
}
