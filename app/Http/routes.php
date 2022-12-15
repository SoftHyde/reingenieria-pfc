<?php
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckBan;
use Spatie\Analytics\Period;

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
	'uses' => 'Auth\LoginController@ShowLoginForm',
	'as' => 'login'
	]);

Route::post('iniciar-sesion',['as' => 'login.post', 'uses' => 'Auth\LoginController@login'])->middleware(CheckBan::class);;

Route::get('cerrar-sesion', [
	'uses' => 'Auth\LoginController@logout',
	'as' => 'logout'
	]);


//Registro
Route::get('registro', [
	'uses' => 'Auth\RegisterController@showRegistrationForm',
	'as' => 'register'
	]);

Route::post('registro',['as' => 'register.post','uses'=> 'Auth\RegisterController@register']);

Route::get('confirmation/{token}', [
	'uses' => 'Auth\RegisterController@getConfirmation',
	'as' => 'confirmation'
	]);


//Recuperar contraseña
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');


Route::get('password/reset', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');


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

//Nuevas Rutas
Route::get('proyectos', [
	'uses'	=> 'ProjectController@index',
	'as'	=> 'projects'
	]);

Route::get('proyectos/{id}', [
'uses'	=> 'ProjectController@show',
'as'	=> 'project'
]);

Route::get('proyectos/tag/{tag}', [
	'uses'	=> 'ProjectController@showTag',
	'as'	=> 'projectTag'
	]);

Route::get('accion-participativa/tag/{tag}', [
	'uses'	=> 'ActionController@showTag',
	'as'	=> 'actionTag'
	]);




Route::get('article/{id}/{numero}', [
	'uses'	=> 'ArticleController@show',
	'as'	=> 'article'
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

		Route::get('/stats', [
			'uses' 	=> 'AdminController@getStats',
			'as' 	=> 'settings'
			]);
		
		
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
		Route::get('info-usuarios/{meses}', [
			'uses'	=> 'AdminController@info_users',
			'as'	=> 'admin.info_users'
			]);
		Route::get('info-tipos-usuarios', [
			'uses'	=> 'AdminController@index_users',
			'as'	=> 'admin.info_users_type'
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
		// Info para tags			
		Route::get('info-tags', [
			'uses'	=> 'TagController@index',
			'as'	=> 'tag.index'
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
		
		Route::get('administracion/crear-proyecto', [
			'uses' 	=> 'ProjectController@create',
			'as' 	=> 'project.create'
			]);

		Route::post('administracion/crear-proyecto', [
			'uses' 	=> 'ProjectController@store',
			'as'	=> 'project.store'
			]);

		Route::get('proyectos/editar-proyecto/{id}', [
			'uses' 	=> 'ProjectController@edit',
			'as'	=> 'project.edit'
			]);
		
		Route::put('proyectos/editar-proyecto/{id}', [
			'uses'	=> 'ProjectController@update',
			'as'	=> 'project.update'
			]);

		Route::delete('eliminar-projecto', [
			'uses'	=> 'ProjectController@destroy',
			'as'	=> 'project.delete'
			]);


		

	});

	//Comentarios Articulos

	Route::post('comentar-articulo', [
		'uses'	=> 'ArticleController@postComment',
		'as'	=> 'article.comment'
		]);
	
	Route::get('editar-comentario-articulo/{id}/{numero}', [
		'uses'	=> 'CommentArticleController@edit',
		'as'	=> 'commentarticle.edit'
		]);

	Route::put('editar-comentario-articulo/{id}/{numero}', [
		'uses'	=> 'CommentArticleController@update',
		'as'	=> 'commentarticle.update'
		]);

	Route::post('me-gusta-comentario-articulo', [
		'uses'	=> 'CommentArticleController@like',
		'as'	=> 'commentarticle.like'
		]);	

	Route::delete('ya-no-me-gusta-comentario-articulo', [
		'uses'	=> 'CommentArticleController@unlike',
		'as'	=> 'commentarticle.unlike'
		]);

	Route::delete('borrar-comentario-articulo', [
		'uses'	=> 'CommentArticleController@destroy',
		'as'	=> 'commentarticle.delete'
		]);

	Route::get('denunciar-comentario-articulo/{id}/{numero}', [
		'uses'	=> 'CommentArticleController@report',
		'as'	=> 'commentarticle.report'
		]);
	//Comentar Projectos
	Route::post('comentar-projecto', [
		'uses'	=> 'ProjectController@postComment',
		'as'	=> 'project.comment'
		]);
	
	Route::get('editar-comentario-projecto/{id}', [
		'uses'	=> 'CommentProjectController@edit',
		'as'	=> 'commentproject.edit'
		]);

	Route::put('editar-comentario-projecto/{id}', [
		'uses'	=> 'CommentProjectController@update',
		'as'	=> 'commentproject.update'
		]);

	Route::post('me-gusta-comentario-projecto', [
		'uses'	=> 'CommentProjectController@like',
		'as'	=> 'commentproject.like'
		]);	

	Route::delete('ya-no-me-gusta-comentario-projecto', [
		'uses'	=> 'CommentProjectController@unlike',
		'as'	=> 'commentproject.unlike'
		]);

	Route::delete('borrar-comentario-projecto', [
		'uses'	=> 'CommentProjectController@destroy',
		'as'	=> 'commentproject.delete'
		]);

	Route::get('denunciar-comentario-projecto/{id}', [
		'uses'	=> 'CommentProjectController@report',
		'as'	=> 'commentproject.report'
		]);
	
	//Apoyo Articulo

	Route::post('apoyar-articulo', [
		'uses'	=> 'ArticleController@support',
		'as'	=> 'article.support'
		]);

	Route::delete('quitar-apoyo-articulo', [
		'uses'	=> 'ArticleController@unsupport',
		'as'	=> 'article.unsupport'
		]);
	
	
	
	Route::get('crear-articulo/{project_id}', [
	'uses'	=> 'ProjectController@getCreateArticle',
	'as'	=> 'create-article-form'
	]);

	Route::post('crear-articulo', [
		'uses'	=> 'ProjectController@postCreateArticle',
		'as'	=> 'create-article'
		]);

	Route::get('editar-articulo/{id}/{numero}', [
		'uses'	=> 'ArticleController@edit',
		'as'	=> 'article.edit'
		]);

	Route::put('editar-articulo/{id}/{numero}', [
		'uses'	=> 'ArticleController@update',
		'as'	=> 'article.update'
		]);

	Route::delete('borrar-articulo', [
		'uses'	=> 'ArticleController@destroy',
		'as'	=> 'article.delete'
		]);
	

});