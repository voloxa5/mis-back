<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('templates')->delete();

        DB::table('templates')->insert(
            [
                [
                    'name' => 'template1',
                    'description' => 'справка',
                    'content' => null,
                    'domain_id' => '1'
                ],
                [
                    'name' => 'template2',
                    'description' => '№2',
                    'content' => null,
                    'domain_id' => '2'
                ],
                [
                    'name' => 'template3',
                    'description' => '№3',
                    'content' => null,
                    'domain_id' => '3'
                ],
                [
                    'name' => 'template4',
                    'description' => '№4',
                    'content' => null,
                    'domain_id' => '4'
                ],
            ]
        );
    }
}
