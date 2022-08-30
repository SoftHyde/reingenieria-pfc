<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccederPropuestaTest extends TestCase
{
    use DatabaseTransactions;

	public function testAccederPropuesta(){

		$user = $this->createUser('general');

		$this->actingAs($user)
			->visit('/')
			->click('Consejo de niños y niñas')
			->seePageIs('accion-participativa/1')
			->click('Puestos saludables en parques')
			->seePageIs('propuesta/1')
			->see('Puestos saludables en parques');

	}
}
