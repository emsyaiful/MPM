<?php

use Illuminate\Database\Seeder;

class Status_dealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_dealers')->insert([
        	'id_status_dealer' => Uuid::generate(),
        	'nama_status'=> 'Aktif',
        ]);
        DB::table('status_dealers')->insert([
        	'id_status_dealer' => Uuid::generate(),
        	'nama_status'=> 'Menunggu',
        ]);
        DB::table('status_dealers')->insert([
        	'id_status_dealer' => Uuid::generate(),
        	'nama_status'=> 'Pasif',
        ]);
    }
}
