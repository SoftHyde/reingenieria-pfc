<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApoyarPropuestaTest extends TestCase
{
    use DatabaseTransactions;

	public function testApoyarPropuesta()
    {
        $user = $this->createUser('general');

		$this->actingAs($user)
			->visit('propuesta/1')
			->see('Apoyar')
			->press('Apoyar');

		$this->seeInDatabase('user_support_proposal', [
			'user_id'		=> $user->id,
			'proposal_id'	=> 1
			]);

    }
}
