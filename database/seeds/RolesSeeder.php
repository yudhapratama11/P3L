<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'nama' => 'Administrator'
        ]);
        DB::table('roles')->insert([
            'nama' => 'Customer Service'
        ]); 
        DB::table('roles')->insert([
            'nama' => 'Montir'
        ]); 
        DB::table('roles')->insert([
            'nama' => 'Kasir'
        ]); 
    }
}
