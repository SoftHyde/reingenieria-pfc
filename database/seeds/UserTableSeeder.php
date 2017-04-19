<?php

use Illuminate\Database\Seeder;

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

        factory(App\User::class)->create([
        	'name' => 'Jerónimo Admin',
        	'role' => 'admin',
        	'email' => 'jeronimo.calace@gmail.com',
        	'password' =>  bcrypt('admin')
        ]);

        factory(App\User::class)->create([
            'name' => 'Jerónimo General',
            'role' => 'general',
            'email' => 'jeronimo.calace+general@gmail.com',
            'password' =>  bcrypt('general')
        ]);

        factory(App\User::class, 48)->create();
    }
}
