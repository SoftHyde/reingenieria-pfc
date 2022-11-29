<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->delete();

        App\User::factory()->create([
        	'name' => 'Jerónimo Admin',
        	'role' => 'admin',
        	'email' => 'jeronimo.calace+admin@gmail.com',
        	'password' =>  bcrypt('123456')
        ]);

        App\User::factory()->create([
            'name' => 'Jerónimo General',
            'role' => 'general',
            'email' => 'jeronimo.calace+general@gmail.com',
            'password' =>  bcrypt('123456')
        ]);
  

       
        App\User::factory(10)->create();
    }
}