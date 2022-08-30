<?php
use Illuminate\Http\Request;
use App\Poll;
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



// Usuarios no autenticados

//Inicio
Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'home'
	]
);


//Login
Route::get('iniciar-sesion', [
	'uses' => 'Auth\AuthController@getLogin',
	'as' => 'login'
	]);

Route::post('iniciar-sesion', 'Auth\AuthController@postLogin');

Route::get('cerrar-sesion', [
	'uses' => 'Auth\AuthController@getLogout',
	'as' => 'logout'
	]);


//Registro
Route::get('registro', [
	'uses' => 'Auth\AuthController@getRegister',
	'as' => 'register'
	]);

Route::post('registro', 'Auth\AuthController@postRegister');

Route::get('confirmation/{token}', [
	'uses' => 'Auth\AuthController@getConfirmation',
	'as' => 'confirmation'
	]);


//Recuperar contraseña
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


//Login con redes sociales
Route::get('redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/callback/{provider}', 'SocialAuthController@callback');


//Acciones participativas
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


//Obras
Route::get('obras/{id}', [
	'uses'	=> 'WorkController@show',
	'as'	=> 'works'
	]);


//Perfil de usuario
Route::get('usuarios/{id}', [
	'uses'	=> 'UserController@show',
	'as'	=> 'user'
	]);



// Usuarios autenticados
Route::group(['middleware' => 'auth'], function () {

	//Acciones
	Route::get('editar-accion/{id}',[
		'uses' 	=> 'ActionController@getEditAction',
		'as' 	=> 'edit-action'
		]);

	Route::get('accion-participativa/editar/{id}', [
		'uses'	=> 'ActionController@edit',
		'as'	=> 'action.edit'
		]);

	Route::put('accion-participativa/actualizar/{id}', [
		'uses'	=> 'ActionController@update',
		'as'	=> 'action.update'
		]);

	//Noticias y Eventos
	Route::get('publicar-noticia/{action_id}', [
		'uses'	=> 'NewventController@publishNew',
		'as'	=> 'new.publish'
		]);

	Route::get('publicar-evento/{action_id}', [
		'uses'	=> 'NewventController@publishEvent',
		'as'	=> 'event.publish'
		]);

	Route::post('guardar-evento-o-noticia', [
		'uses'	=> 'NewventController@store',
		'as'	=> 'newvent.store'
		]);

	Route::get('editar-evento-o-noticia/{newvent_id}', [
		'uses'	=> 'NewventController@edit',
		'as'	=> 'newvent.edit'
		]);

	Route::put('editar-noticia-o-evento/{id}', [
		'uses'	=> 'NewventController@update',
		'as'	=> 'newvent.update'
		]);

	Route::delete('borrar-noticia-o-evento', [
		'uses'	=> 'NewventController@destroy',
		'as'	=> 'newvent.delete'
		]);


	//Propuestas
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

	Route::get('editar-propuesta/{id}', [
		'uses'	=> 'ProposalController@edit',
		'as'	=> 'proposal.edit'
		]);

	Route::put('editar-propuesta/{id}', [
		'uses'	=> 'ProposalController@update',
		'as'	=> 'proposal.update'
		]);

	Route::post('apoyar-propuesta', [
		'uses'	=> 'ProposalController@support',
		'as'	=> 'proposal.support'
		]);

	Route::delete('quitar-apoyo-propuesta', [
		'uses'	=> 'ProposalController@unsupport',
		'as'	=> 'proposal.unsupport'
		]);

	Route::delete('borrar-propuesta', [
		'uses'	=> 'ProposalController@destroy',
		'as'	=> 'proposal.delete'
		]);

	Route::get('cerrar-propuesta/{id}', [
		'uses'	=> 'ProposalController@getClose',
		'as'	=> 'proposal.getclose'
		]);

	Route::put('cerrar-propuesta/{id}', [
		'uses'	=> 'ProposalController@putClose',
		'as'	=> 'proposal.putclose'
		]);

	Route::get('reabrir-propuesta/{id}', [
		'uses'	=> 'ProposalController@reOpen',
		'as'	=> 'proposal.reopen'
		]);
	


	//Comentarios
	Route::get('editar-comentario/{id}', [
		'uses'	=> 'CommentController@edit',
		'as'	=> 'comment.edit'
		]);

	Route::put('editar-comentario/{id}', [
		'uses'	=> 'CommentController@update',
		'as'	=> 'comment.update'
		]);

	Route::post('me-gusta-comentario', [
		'uses'	=> 'CommentController@like',
		'as'	=> 'comment.like'
		]);

	Route::delete('ya-no-me-gusta-comentario', [
		'uses'	=> 'CommentController@unlike',
		'as'	=> 'comment.unlike'
		]);

	Route::delete('borrar-comentario', [
		'uses'	=> 'CommentController@destroy',
		'as'	=> 'comment.delete'
		]);

	Route::get('denunciar-comentario/{id}', [
		'uses'	=> 'CommentController@report',
		'as'	=> 'comment.report'
		]);


	//Encuestas
	Route::get('crear-votacion/{action_id}', [
		'uses'	=> 'PollController@getCreate',
		'as'	=> 'action.create-poll'
		]);
	
	Route::post('crear-votacion', [
		'uses'	=> 'PollController@postCreate',
		'as'	=> 'create-poll'
		]);

	Route::any('eliminar-votacion/{id}', [
		'uses'	=> 'PollController@destroy',
		'as'	=> 'poll.delete'
		]);

	Route::any('terminar-votacion/{id}', [
		'uses'	=> 'PollController@end',
		'as'	=> 'poll.end'
		]);

	Route::any('votar', [
		'uses'	=> 'PollController@vote',
		'as'	=> 'vote'
		]);


	//Obras
	Route::get('publicar-obra/{action_id}', [
		'uses'	=> 'WorkController@getCreate',
		'as'	=> 'work.publish'
		]);

	Route::post('publicar-obra', [
		'uses'	=> 'WorkController@postCreate',
		'as'	=> 'work.post-create'
		]);

	Route::post('calificar', [
		'uses'	=> 'WorkController@rate',
		'as'	=> 'rate'
		]);

	Route::delete('borrar-obra', [
		'uses'	=> 'WorkController@destroy',
		'as'	=> 'work.delete'
		]);

	Route::get('editar-obra/{id}', [
		'uses'	=> 'WorkController@edit',
		'as'	=> 'work.edit'
		]);

	Route::put('editar-obra/{id}', [
		'uses'	=> 'WorkController@update',
		'as'	=> 'work.update'
		]);


	//Perfil de usuario
	Route::get('editar-perfil',[
		'uses'	=> 'UserController@edit',
		'as'	=> 'user.edit'
		]);

	Route::put('actualizar-perfil/{id}',[
		'uses'	=> 'UserController@update',
		'as'	=> 'user.update'
		]);

	Route::get('cambiar-contrasena', [
		'uses'	=> 'UserController@getChangePassword',
		'as'	=> 'user.change-password'
		]);

	Route::put('actualizar-contrasena', [
		'uses'	=> 'UserController@postChangePassword',
		'as'	=> 'user.post-change-password'
		]);



	// Administador de la plataforma
	Route::group(['middleware' => 'role:admin'], function () {

		// Panel de administrador
		Route::get('administracion', [
			'uses' 	=> 'AdminController@getSettings',
			'as' 	=> 'settings'
			]);

		// Info para grafico de progresion mensual
		Route::get('info-mensual/{meses}', [
			'uses'	=> 'AdminController@info_months',
			'as'	=> 'admin.info_months'
			]);

		// Crear accion participativa
		Route::get('administracion/crear-accion-participativa', [
			'uses' 	=> 'ActionController@create',
			'as' 	=> 'action.create'
			]);

		Route::post('administracion/crear-accion-participativa', [
			'uses' 	=> 'ActionController@store',
			'as'	=> 'action.store'
			]);

		// Eliminar accion participativa
		Route::delete('eliminar-accion', [
		'uses'	=> 'ActionController@destroy',
		'as'	=> 'action.delete'
		]);

		// Info de usuarios para filtrar al seleccionar admin de accion
		Route::get('info-usuarios', [
			'uses'	=> 'UserController@index',
			'as'	=> 'users.index'
			]);
		// Info para grafico de distritos
		Route::get('info-distritos', [
			'uses'	=> 'UserController@index_districts',
			'as'	=> 'users.index_districts'
			]);


		// Usuarios
		Route::get('suspender-usuario/{id}', [
			'uses'	=> 'UserController@ban',
			'as'	=> 'user.ban'
			]);

		Route::put('suspender-usuario/{id}', [
			'uses'	=> 'UserController@putBan',
			'as'	=> 'user.putban'
			]);

		Route::get('habilitar-usuario/{id}', [
			'uses'	=> 'UserController@unban',
			'as'	=> 'user.unban'
			]);

		Route::get('crear-usuario', [
			'uses' 	=> 'UserController@getCreate',
			'as'	=> 'user.create'
			]);

		Route::post('post-crear-usuario', [
			'uses' 	=> 'UserController@postCreate',
			'as'	=> 'user.postcreate'
			]);

		

	});

});