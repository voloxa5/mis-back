<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->delete();

        DB::table('domains')->insert(
            [
                [
                    'name' => 'Shift',
                    'title' => 'Справка'
                ],
                [
                    'name' => 'Warehouse',
                    'title' => 'Склад'
                ],
                [
                    'name' => 'Task',
                    'title' => 'Задание'
                ],
                [
                    'name' => 'Supervision',
                    'title' => 'Сводка'
                ],
                [
                    'name' => 'Document',
                    'title' => 'Документ'
                ],
                [
                    'name' => 'DocumentDefinition',
                    'title' => 'Документ'
                ],
            ]);
    }
}
