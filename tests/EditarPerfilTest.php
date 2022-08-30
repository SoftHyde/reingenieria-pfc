<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditarPerfilTest extends TestCase
{
    use DatabaseTransactions;

    public function testEditarPerfil()
    {
    	
        $general = $this->createUSer('general');
        $this->actingAs($general)
        	->visit('usuarios/' . $general->id)
        	->see('Ajustes')
        	->click('Editar perfil')
        	->seePageIs('usuarios/1/editar-perfil')
        	->type('Carlos', 'name')
        	->type('carlos@general.com', 'email')
        	->press('Guardar cambios')
        	->seePageIs('usuarios/' . $general->id)
        	->see('Perfil actualizado')
        	->seeInDataBase('users', [
        		'name' => 'Carlos',
        		'email' => 'carlos@gmail.com'
        		]);


        $general_2 = $this->createUSer('general');
        $this->actingAs($general_2)
        	->visit('usuarios/' . $general->id)
        	->dontSee('Ajustes');


        $admin = $this->createUSer('admin');
        $this->actingAs($admin)
        	->visit('usuarios/' . $general->id)
        	->see('Ajustes')
        	->dontSee('Editar perfil');

    }
}
