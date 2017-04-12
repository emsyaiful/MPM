<?php

use Illuminate\Database\Seeder;

class User_statusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
        	'id' => 1,
        	'role' => 'Admin',
        ]);
        DB::table('user_statuses')->insert([
        	'id' => 3,
        	'role' => 'Divisi',
        ]);
        DB::table('user_statuses')->insert([
        	'id' => 2,
        	'role' => 'Dealer',
        ]);
    }
}
