<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EliminarPropuesta extends TestCase
{
    use DatabaseTransactions;

    public function testCrearPropuesta()
    {
        $user = $this->createUSer('admin');

        $this->actingAs($user)
        	->visit('propuesta/1')
        	->press('Eliminar propuesta')
        	->see('¿Estás seguro de que deseas eliminarla?')
        	->press('Si')
           	->seePageIs('accion-participativa/1')
        	->see('La propuesta ha sido eliminada con éxito')
        	->notSeeInDatabase('proposals', [
        		'id'	=>	1
        		]);
    }
}
