<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
* 
*/
class CrearAPTest extends TestCase
{
	use DatabaseTransactions;

	public function testCrearAP(){

		$user = $this->createUser('admin');

		$this->actingAs($user)
			->visit('administracion')
			->click('Crear acción participativa')
			->seePageIs('administracion/crear-accion-participativa')
			->type('Consejo de niñas y niños', 'title')
			->type('Esta accion participativa está orientada a ...', 'description')
			->type($user->email, 'admin_email')
			->check('create_p')
			->press('Crear acción participativa')
			->seePageIs('administracion')
			->see('La acción participativa ha sido creada con éxito')
			->seeInDatabase('actions', [
				'title' => 'Consejo de niñas y niños',
				'description' => 'Esta accion participativa está orientada a ...',
				'admin_email' => $user->email,
				'create_p' => 1
				]);

	}

}