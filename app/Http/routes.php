<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home route...
Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'home'
	]
);

// Authentication routes...
Route::get('iniciar-sesion', [
	'uses' => 'Auth\AuthController@getLogin',
	'as' => 'login'
	]);
Route::post('iniciar-sesion', 'Auth\AuthController@postLogin');
Route::get('cerrar-sesion', [
	'uses' => 'Auth\AuthController@getLogout',
	'as' => 'logout'
	]);

// Registration routes...
Route::get('registro', [
	'uses' => 'Auth\AuthController@getRegister',
	'as' => 'register'
	]);

Route::post('registro', 'Auth\AuthController@postRegister');

Route::get('confirmation/{token}', [
	'uses' => 'Auth\AuthController@getConfirmation',
	'as' => 'confirmation'
	]);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Acciones participativas
Route::get('acciones-participativas', [
	'uses'	=> 'ActionController@index',
	'as'	=> 'actions'
	]);
Route::get('accion-participativa/{id}', [
	'uses'	=> 'ActionController@show',
	'as'	=> 'action'
	]);

//Propuestas
Route::get('propuesta/{id}', [
	'uses'	=> 'ProposalController@show',
	'as'	=> 'proposal'
	]);

// Usuarios autenticados
Route::group(['middleware' => 'auth'], function () {

	// General
	Route::get('editar-accion/{id}',[
		'uses' 	=> 'ActionController@getEditAction',
		'as' 	=> 'edit-action'
		]);

	Route::get('crear-propuesta/{action_id}', [
		'uses'	=> 'ActionController@getCreateProposal',
		'as'	=> 'create-proposal-form'
		]);

	Route::post('crear-propuesta', [
		'uses'	=> 'ActionController@postCreateProposal',
		'as'	=> 'create-proposal'
		]);

	Route::post('comentar-propuesta', [
		'uses'	=> 'ProposalController@postComment',
		'as'	=> 'proposal.comment'
		]);

	Route::post('apoyar-propuesta', [
		'uses'	=> 'ProposalController@support',
		'as'	=> 'proposal.support'
		]);

	Route::delete('quitar-apoyo-propuesta', [
		'uses'	=> 'ProposalController@unsupport',
		'as'	=> 'proposal.unsupport'
		]);

	Route::post('votar', [
		'uses'	=> 'PollController@vote',
		'as'	=> 'vote'
		]);
	

	// Admin de Accion Participativa
	//...

	Route::get('crear-votacion/{action_id}', [
		'uses'	=> 'PollController@getCreate',
		'as'	=> 'action.create-poll'
		]);
	
	Route::post('crear-votacion', [
		'uses'	=> 'PollController@postCreate',
		'as'	=> 'create-poll'
		]);

	Route::get('publicar-obra/{action_id}', [
		'uses'	=> 'WorkController@getCreate',
		'as'	=> 'work.publish'
		]);

	Route::post('publicar-obra', [
		'uses'	=> 'WorkController@postCreate',
		'as'	=> 'work.post-create'
		]);


	// Administador de la plataforma
	Route::group(['middleware' => 'role:admin'], function () {

		// Panel de administrador
		Route::get('administracion', [
			'uses' 	=> 'AdminController@getSettings',
			'as' 	=> 'settings'
			]);
		// Crear accion participativa
		Route::get('administracion/crear-accion-participativa', [
			'uses' 	=> 'AdminController@getCreateAction',
			'as' 	=> 'settings/create-action'
			]);
		Route::post('administracion/crear-accion-participativa', [
			'uses' 	=> 'AdminController@postCreateAction',
			'as'	=> 'settings/create-action'
			]);
		

	});

});