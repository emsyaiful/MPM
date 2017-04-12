<?php

use Illuminate\Database\Seeder;

class User_divisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'DEV',
        	'nama' => 'DEVELOPMENT',
        ]);
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'PROM',
        	'nama' => 'PROMOTION',
        ]);
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'H123',
        	'nama' => 'H123',
        ]);
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'TSD',
        	'nama' => 'TSD',
        ]);
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'PARTS',
        	'nama' => 'PARTS',
        ]);
        DB::table('user_divisions')->insert([
        	'id_division' => Uuid::generate(),
        	'kode_divisi' => 'HC3',
        	'nama' => 'HC3',
        ]);
    }
}
