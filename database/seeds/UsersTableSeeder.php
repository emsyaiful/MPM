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
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('initpass'),
            'user_status' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
