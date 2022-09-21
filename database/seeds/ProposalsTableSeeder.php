<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProposalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposals')->delete();

        $proposal=[
            [
        	'title' => 'Puestos saludables en parques',
        	'content' => 'Propongo construir puestos saludables en los parques de la ciudad. Donde se pueda hacer ejercicios y tomar agua.',
        	'action_id' => 1,
        	'user_id' => 2
            ],

            [
        	'title' => 'Más luces en las calles',
        	'content' => 'Propongo poner más luces en las calles de la ciudad. Esto puede traer más seguridad y evitar accidentes.',
        	'action_id' => 1,
        	'user_id' => 2
            ],
            [

        
            'title' => 'Veredas más anchas',
            'content' => 'Propongo ensachar las veredas en el barrio equis para poder plantar árboles y disminuir la velocidad de los autos.',
            'action_id' => 1,
            'user_id' => 2
            ]];
        DB::table('proposals')->insert($proposal);        
        App\Proposal::factory(15)->create();
    }
}
