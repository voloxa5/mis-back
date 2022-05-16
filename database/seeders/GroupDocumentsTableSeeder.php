<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_documents')->delete();

        DB::table('group_documents')->insert(
            [
                [
                    'group_id' => 1,
                    'document_id' => 1
                ],
                [
                    'group_id' => 8,
                    'document_id' => 2
                ]
            ]
        );
    }
}
