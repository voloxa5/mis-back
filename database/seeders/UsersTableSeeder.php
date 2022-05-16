<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();

        DB::table('users')->insert(
            [
                [
                    'name' => 'user1',
                    'is_admin' => 'false',
                    'email' => 'user1',
                    'password' => bcrypt('1'),
                ],
                [
                    'name' => 'user2',
                    'is_admin' => 'true',
                    'email' => 'user2',
                    'password' => bcrypt('2'),
                ],
                [
                    'name' => 'user3',
                    'is_admin' => 'false',
                    'email' => 'user3',
                    'password' => bcrypt('3'),
                ],
                [
                    'name' => 'user4',
                    'is_admin' => 'false',
                    'email' => 'user4',
                    'password' => bcrypt('4'),
                ],
                [
                    'name' => 'user5',
                    'is_admin' => 'false',
                    'email' => 'user5',
                    'password' => bcrypt('5'),
                ],
            ]
        );
    }
}
