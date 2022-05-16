<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();

        DB::table('groups')->insert(
            [
                [
                    // 1
                    'title' => 'Иванов А.И.',
                    'name' => 'user1',
                    'user_id' => 1,
                ],
                [
                    // 2
                    'title' => 'Степанова Е.А.',
                    'name' => 'user2',
                    'user_id' => 2,
                ],
                [
                    // 3
                    'title' => 'Кудрин И.С.',
                    'name' => 'user3',
                    'user_id' => 3,
                ],
                [
                    // 4
                    'title' => 'Сергеев В.А.',
                    'name' => 'user4',
                    'user_id' => 4,
                ],
                [
                    // 5
                    'title' => 'ФЭО',
                    'name' => 'group1',
                    'user_id' => null,
                ],
                [
                    // 6
                    'title' => 'Гараж',
                    'name' => 'group2',
                    'user_id' => null,
                ],
                [
                    // 7
                    'title' => 'ОК',
                    'name' => 'group3',
                    'user_id' => null,
                ],
                [
                    // 8
                    'title' => 'Руководство гаража',
                    'name' => 'group4',
                    'user_id' => null,
                ],
            ]
        );
    }
}
