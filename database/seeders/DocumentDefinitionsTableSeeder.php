<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentDefinitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_definitions')->delete();

        DB::table('document_definitions')->insert(
            [
                [
                    'name' => 'Справка',
                    'title' => 'Справка',
                    'description' => 'Тип документа - справка',
                    'domain_id' => '1',
                    'form_id' => '1',
                    'template_id' => '1',
                ],
            ]
        );
    }
}
