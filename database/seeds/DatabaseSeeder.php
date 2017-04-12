<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KaresTableSeeder::class);
    	$this->call(User_divisionsTableSeeder::class);
    	$this->call(MdsTableSeeder::class);
    	$this->call(Status_dealersTableSeeder::class);
    	$this->call(User_statusesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
