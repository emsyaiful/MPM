<?php

use Illuminate\Database\Seeder;

class KaresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kares')->insert([
        	'id_kares' => Uuid::generate(),
        	'nama_kares' => 'Simbah',
        ]);
        DB::table('kares')->insert([
        	'id_kares' => Uuid::generate(),
        	'nama_kares' => 'Bapak',
        ]);
        DB::table('kares')->insert([
        	'id_kares' => Uuid::generate(),
        	'nama_kares' => 'Ibuk',
        ]);
    }
}
