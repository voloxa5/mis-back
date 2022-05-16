<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->truncate();

        DB::table('programs')->insert(
            [
                [
                    'name' => 'documents',
                    'title' => 'Документы',
                ],
                [
                    'name' => 'forms',
                    'title' => 'Формы',
                ],
                [
                    'name' => 'templates',
                    'title' => 'Шаблоны',
                ],
                [
                    'name' => 'groups',
                    'title' => 'Управление группами',
                ],
                [
                    'name' => 'users',
                    'title' => 'Управление пользователями',
                ],
            ]
        );
    }
}
