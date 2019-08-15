<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'id' => 1,
        	'name' => 'Khurniawan Eko',
	        'email' => 'eko@ruangsepuluh.com',
	        'password' =>  '$2y$10$oZ7Sxdyd5LfIaW7Sgf9rpeN2q2U.EfKZ5LTFhae26HELrqJkYt856',
        ]);
    }
}
