<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->delete();

        DB::table('documents')->insert(
            [
                [
                    'type' => 'text',
                    'title' => 'Документ 1',
                    'content' => '',
                    'domain_type_id' => 2,
                    'domain_id' => 1,
                    'reg_number' => '34',
                    'reg_date' => Carbon::create(2019, 11, 22),
                    'creator_id' => '1',
                    'owner_id' => '1',
                    'sender_id' => null,
                    'addressee_id' => null,
                    'form_id' => 1,
                    'template_id' => 1,
                    'secrecy_degree_id' => 1,
                    'document_definition_id' => 1,
                ],
                [
                    'type' => 'text',
                    'title' => 'Документ 2',
                    'content' => '',
                    'domain_type_id' => 2,
                    'domain_id' => 2,
                    'reg_number' => '57',
                    'reg_date' => Carbon::create(2019, 10, 14),
                    'creator_id' => '1',
                    'owner_id' => '1',
                    'sender_id' => null,
                    'addressee_id' => null,
                    'form_id' => 1,
                    'template_id' => 1,
                    'secrecy_degree_id' => 1,
                    'document_definition_id' => 1,
                ],
            ]
        );
    }
}
