<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
* 
*/
class MenuTest extends TestCase
{

	use DatabaseTransactions;

	public function testLinkAdministracion(){

		// Usuario anonimo
		$this->visit('/')->dontSee('Administración');
		$this->visit('administracion')->see('Iniciar sesión');

		// Usuario general
		$user = $this->createUser('general');
                $this->actingAs($user)
                	->visit('/')
                	->dontSee('Administración');
                $this->actingAs($user)
                	->get('/administracion')
                	->seeStatusCode('404');

                // Usuario action_admin
        	$user = $this->createUser('action_admin');
                $this->actingAs($user)
                	->visit('/')
                	->dontSee('Administración');
                $this->actingAs($user)
                	->get('/administracion')
                	->seeStatusCode('404');
                	
                // Usuario admin
        	$user = $this->createUser('admin');
                $this->actingAs($user)
                	->visit('/')
                	->see('Administración');

                $this->actingAs($user)
                        ->click('Administración')
                	->seePageIs('administracion')
                	->see('Administración');
        }
}