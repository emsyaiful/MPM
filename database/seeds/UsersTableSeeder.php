<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 		DB::table('users')->insert([
        	'id' => Uuid::generate(),
        	'role_id' => 1,
        	'name' => 'testing',
        	'email' => 'tes@mail.com',
        	'password' => bcrypt('initpass'),
        	'created_at' => Carbon::now(),
        	'alamat' => 'jalan tes',
        ]);

        DB::table('users')->insert([
        	'id' => Uuid::generate(),
        	'role_id' => 2,
        	'name' => 'testing 1',
        	'email' => 'tes1@mail.com',
        	'password' => bcrypt('initpass'),
        	'created_at' => Carbon::now(),
        	'alamat' => 'jalan tes',
        ]);

        DB::table('users')->insert([
        	'id' => Uuid::generate(),
        	'role_id' => 3,
        	'name' => 'testing 2',
        	'email' => 'tes2@mail.com',
        	'password' => bcrypt('initpass'),
        	'created_at' => Carbon::now(),
        	'alamat' => 'jalan tes',
        ]);

        DB::table('users')->insert([
            'id' => Uuid::generate(),
            'role_id' => 3,
            'name' => 'testing 3',
            'email' => 'tes3@mail.com',
            'password' => bcrypt('initpass'),
            'created_at' => Carbon::now(),
            'alamat' => 'jalan tes',
        ]);
    }
}
