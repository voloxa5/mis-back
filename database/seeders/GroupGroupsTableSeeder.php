<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_groups')->delete();

        DB::table('group_groups')->insert(
            [
                [
                    'parent_id' => 5,
                    'child_id' => 2,
                ],
                [
                    'parent_id' => 7,
                    'child_id' => 4,
                ],
                [
                    'parent_id' => 6,
                    'child_id' => 1,
                ],
                [
                    'parent_id' => 8,
                    'child_id' => 1,
                ],
                [
                    'parent_id' => 6,
                    'child_id' => 3,
                ],
            ]
        );
    }
}
