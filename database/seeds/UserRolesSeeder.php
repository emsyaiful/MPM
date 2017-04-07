<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
        	'nama' => 'Kepala Cabang',
        	'divisi' => 'Kepala',
        ]);

        DB::table('user_roles')->insert([
        	'nama' => 'Kepala Divisi Maintenance',
        	'divisi' => 'Maintenance',
        ]);

        DB::table('user_roles')->insert([
        	'nama' => 'Kepala Divisi Pengadaan',
        	'divisi' => 'Pengadaan',
        ]);
    }
}
