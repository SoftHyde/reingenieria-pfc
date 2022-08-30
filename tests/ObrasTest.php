<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObrasTest extends TestCase
{
    use DatabaseTransactions;

    public function testPublicarObra()
    {
        $user = $this->createUSer('admin');

        $this->actingAs($user)
        	->visit('accion-participativa/1')
        	// ->press('Administrar')
        	->click('Publicar obra del municipio')
        	->seePageIs('publicar-obra/1')
        	->see('Publicar obra')
        	->type('Metrobus', 'title')
        	->type('Se está construyendo el metrobus en la zona...', 'content')
        	->press('Publicar')
        	->seePageIs('accion-participativa/1')
        	->see('La obra ha sido publicada con éxito')
        	->seeInDataBase('works', [
        		'title' => 'Metrobus',
        		'content' => 'Se está construyendo el metrobus en la zona...'
        		]);
    }

    public function testVerObras()
    {
        $user = $this->createUSer('general');

        $this->actingAs($user)
        	->visit('accion-participativa/2')
        	->see('Obras')
        	->see('Paseo Boulevard');
    }

    
}
