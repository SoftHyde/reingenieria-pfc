<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrearPropuestaTest extends TestCase
{
    use DatabaseTransactions;

    public function testCrearPropuesta()
    {
        $general = $this->createUSer('general');

        $this->actingAs($general)
        	->visit('accion-participativa/1')
        	->see('Crear propuesta')
        	->click('Crear propuesta')
        	->seePageIs('crear-propuesta/1')
        	->see('NUEVA PROPUESTA')
        	->type('Nuevos juegos en las plazas', 'title')
        	->type('Necesitamos nuevos juegos en las plazas porque... Y propongo hacer...', 'content')
        	->press('Publicar propuesta')
        	->seePageIs('accion-participativa/1')
        	->see('La propuesta ha sido creada con éxito')
        	->seeInDataBase('proposals', [
        		'title' => 'Nuevos juegos en las plazas',
        		'content' => 'Necesitamos nuevos juegos en las plazas porque... Y propongo hacer...'
        		]);



    }
}
