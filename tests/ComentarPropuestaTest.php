<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComentarPropuestaTest extends TestCase
{
	/**
     * @group comments
     */

    use DatabaseTransactions;

	public function testComentarPropuesta(){

		// Como usuario anónimo
		$this->visit('propuesta/1')
			->see('Puestos saludables en parques')
			->dontSee('Publicar comentario')
			->see('Inicia sesión para comentar');

		// Como usuario autenticado
		$user = $this->createUser('general');

		$this->actingAs($user)
			->visit('propuesta/1')
			->see('Puestos saludables en parques')
			->see('Comentar')
			->type('Me parece una buena propuesta','comment')
			->press('Publicar comentario');

		$this->seeInDatabase('comments', [
			'comment'		=> 'Me parece una buena propuesta',
			'user_id'		=> $user->id,
			'proposal_id'	=> 1
			]);

		$this->seePageIs('propuesta/1')
				->see('Me parece una buena propuesta');

	}
}
