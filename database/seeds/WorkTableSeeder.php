<?php

use Illuminate\Database\Seeder;

class WorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Work::class)->create([
            'title' => 'Paseo Boulevard',
            'content' => 'El intendente José Corral presentó a los vecinos el proyecto de remodelación del Paseo Boulevard en febrero de 2016. Las obras de puesta en valor comprenden desde el Puente Colgante hasta Avenida Freyre, priorizan la circulación peatonal por sobre la actividad vehicular. ',
            'action_id' => 2
        ]);

        factory(App\Work::class)->create([
            'title' => 'Remodelación de la Avenida Blas Parera',
            'content' => 'La avenida contará con un corredor exclusivo para transporte público de pasajeros urbano y metropolitano en el centro de la traza, en ambos sentidos de circulación, además de una ciclovía. Esa avenida-ruta -que fue centro de tantos reclamos durante años- modificará completamente su fisonomía a lo largo de casi 6 km.',
            'action_id' => 2
        ]);

        factory(App\Work::class, 10)->create();
    }
}
