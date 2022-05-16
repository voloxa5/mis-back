<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupDocumentRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_document_roles')->delete();

        DB::table('group_document_roles')->insert(
            [
                ['id_dict_document_role' => '1', 'id_group_document' => 1],
                ['id_dict_document_role' => '2', 'id_group_document' => 1],
                ['id_dict_document_role' => '2', 'id_group_document' => 2],
            ]);
    }
}
