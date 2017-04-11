<?php

use Illuminate\Database\Seeder;

class MdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mds')->insert([
        	'id_md' => Uuid::generate(),
        	'nama_md' => 'Nasi Padang',
        ]);
        DB::table('mds')->insert([
        	'id_md' => Uuid::generate(),
        	'nama_md' => 'Nasi Goreng',
        ]);
        DB::table('mds')->insert([
        	'id_md' => Uuid::generate(),
        	'nama_md' => 'Nasi Pecel',
        ]);
    }
}
