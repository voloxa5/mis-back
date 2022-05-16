<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictDocumentRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_document_roles')->delete();

        DB::table('dict_document_roles')->insert(
            [
                ['value' => 'reading'],
                ['value' => 'changing'],
                ['value' => 'taking'],
            ]);
    }
}
