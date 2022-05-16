<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DictPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dict_posts')->delete();

        DB::table('dict_posts')->insert(
            [
                [
                    'value' => 'помошник дежурного'
                ],
                [
                    'value' => 'дежурный'
                ],
                [
                    'value' => 'оперуполномоченный'
                ],
                [
                    'value' => 'старший оперуполномоченный'
                ],
                [
                    'value' => 'начальник отдела'
                ],


            ]
        );

    }

}
