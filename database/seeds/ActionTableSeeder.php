<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->delete();

        App\Action::factory()->create([
        	'title'        => 'Consejo de niños y niñas',

        	'description'  => 'Esta acción participativa constituye un dispositivo educativo para el ejercicio temprano de la ciudadanía que genera espacios en los cuales mediante el diálogo, la interacción y el trabajo en equipo se buscan establecer acuerdos, entre los adultos y los niños, que sustenten la idea de ciudad inclusiva, generando propuestas concretas y promoviendo acciones y actitudes en pos de transformar el espacio urbano.
            
            La idea del proyecto es hacer efectiva la participación de los niños y niñas en las cuestiones que conciernen a la ciudad, atendiendo a sus necesidades y expectativas. Niños y niñas, entre 8 y 11 años, de los ocho distritos de la ciudad ejercen su derecho a opinar y a ser oídos mediante el trabajo en las escuelas y en la sesión anual en la que se encuentran con el Intendente de la ciudad para presentarle sus proyectos.',
            'howto'        => 'En esta acción los ciudadanos pueden crear propuestas y debatir en las mismas mediante la publicación de comentarios. Además se puede otorgar un voto de apoyo a las propuestas y finalmente optar por la que se considere más conveniente.',

        	
        	'admin_id'     => 1,
        	'allow_proposals'    => 1,
            'proposal_posters' => 'general',
        	'allow_comments'     => 1,
        	'allow_polls'        => 1,
        	'allow_works'        => 1,
        	'allow_newvents'     => 1
        ]);

         App\Action::factory(5)->create();
    }
}
