@extends('layout')

@section('styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('content')

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2"> 
				<h2>
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					Administración de la plataforma
				</h2>
				@include('partials/success')
				@include('partials/errors')
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"> 
			<div class="row">
				<div class="row">
					<div class="col-md-6">
						<h4>
							<span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
							Acciones participativas
						</h4>
						<a href="{{ route('action.create') }}" class="list-group-item">@lang('admin.create_action') <span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span> </a>
						<br>
						<ul>
							<li>Acciones participativas: <strong>{{$data['actions']}}</strong></li>
							<li>Propuestas creadas: <strong>{{$data['proposals']}}</strong></li>
							<li>Obras publicadas: <strong>{{$data['works']}}</strong></li>
							<li>Comentarios realizados: <strong>{{$data['comments']}}</strong></li>
						</ul>
						@if(count($reported_comments)>0)
							<div class="alert alert-danger">
								<label>Comentarios denunciados</label>
								<br>
								@foreach($reported_comments as $comment)
									<small>
										#{{$comment->id}}: {{ strip_tags(substr($comment->comment, 0,30)) }}... En <a href="{{route('proposal', $comment->proposal_id)}}">{{$comment->proposal->title}}</a>
										<br>
									</small>
								@endforeach
							</div>
						@endif
					</div>
					<div class="col-md-6">
						<h4>
							<span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
							Proyectos de Normativa
						</h4>
						<a href="{{ route('project.create') }}" class="list-group-item">Crear Proyecto de Normativa <span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span> </a>
						<br>
						<ul>
							<li>Proyectos de Normativa: <strong>{{$data['projects']}}</strong></li>
							<li>Articulos creados: <strong>{{$data['articles']}}</strong></li>
							<li>Comentarios realizados a Normativas: <strong>{{$data['commentsProjects']}}</strong></li>
							<li>Comentarios realizados a Articulos: <strong>{{$data['commentsArticles']}}</strong></li>
						</ul>
						
					</div>
				</div>
				<div class="row"> 
					<div class="col-md-6">
						<h4>
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							Usuarios
						</h4>
						<a href="{{route('user.create')}}" class="list-group-item">Crear usuario<span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span> </a>
						<br>
						<ul>
							<li>Usuarios registrados: <strong>{{$data['users']}}</strong></li>
							<li>Usuarios registrados con redes sociales: <strong>{{$data['social_users']}}</strong></li>
							<li>Usuarios suspendidos: <strong>{{$data['banned_users']}}</strong></li>
						</ul>
						@if(count($banned_users)>0)
							<div class="alert alert-info">
								<label>Usuarios suspendidos</label>
								<br>
								@foreach($banned_users as $user)
									<a href="{{route('user', $user->id)}}">{{$user->name}}</a>, 
								@endforeach
							</div>
						@endif
					</div>
				</div>
			</div>
			<hr>
			<h4>
				<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
				Estadísticas
			</h4>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				  Herramienta
				  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				  <li><a onclick="mostrarAcciones()">Acciones Participativas</a></li>
				  <li><a onclick="mostrarProyectos()">Co-Creacion de Normativas</a></li>
				</ul>
			  </div>
			<br>
			<div class="row">
				<div class="col-md-6" id="GraficoAcciones">
					Propuestas, comentarios y calificaciones publicadas por mes:
					<div id="myfirstchart" style="height: 250px;"></div>
				</div>
				<div class="col-md-6" id="GraficoProyectos">
					Proyectos, articulos y comentarios publicados por mes:
					<div id="mythirdchart" style="height: 250px;"></div>
				</div>
				<div class="col-md-6">
					Usuarios por distrito:
					<div id="mysecondchart" style="height: 230px;"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6" align="center">
					<div class="row">
						<div class="col-md-3 col-md-offset-2" align="right">
							Meses:
						</div>
					   	<div class="col-md-3" align="left">
					  		<select class="form-control" id="months_select">
						    	<option>2</option>
						    	<option selected="selected">4</option>
						    	<option>6</option>
						    	<option>12</option>
					  		</select>
				   		</div>
					</div>
				</div>
				<div class="col-md-6">
					<a href="/stats" class="list-group-item">Ver estadísticas de sesiones de usuario <span class="pull-right"> <i class="fa fa-area-chart" aria-hidden="true"></i> <i class="fa fa-bar-chart" aria-hidden="true"></i> <i class="fa fa-line-chart" aria-hidden="true"></i></span> </a>
				</div>
			</div>
			<hr>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script type="text/javascript">

// Grafico de progresion mensual
var months = Morris.Area({
  element: 'myfirstchart',
  data: [
    { y: '2017-01', propuestas: 0, comentarios:0, obras: 0, calificaciones: 0 }
  ],
  xkey: 'y',
  ykeys: ['propuestas', 'comentarios', 'calificaciones'],
  labels: ['Propuestas', 'Comentarios', 'Calificaciones'],
});

var months = Morris.Area({
  element: 'mythirdchart',
  data: [
    { y: '2017-01', projects: 0, articles:0, commentsProjects: 0, commentsArticles: 0 }
  ],
  xkey: 'y',
  ykeys: ['propuestas', 'comentarios', 'calificaciones'],
  labels: ['Propuestas', 'Comentarios', 'Calificaciones'],
});

// Muestro datos de acuerdo la cantidad de meses
$("#months_select")
  .change(function () {
    var n = $( "#months_select option:selected" ).text();
    $.ajax({
      type: "GET",
      dataType: 'json',
      url: "/info-mensual/" + n
    })
    .done(function( data ) {
      months.setData(data);
    })
    .fail(function() {
      alert( "error occured" );
    });
  })
  .change();


// Grafico de usuarios por distrito
var districts = Morris.Donut({
  element: 'mysecondchart',
  data: [{label: 'Santa Fe', value: 100}],
  formatter: function (y, data) { return y + '%' }
});
$.ajax({
      type: "GET",
      dataType: 'json',
      url: "/info-distritos"
    })
    .done(function( data ) {
      districts.setData(data);
    })
    .fail(function() {
      alert( "error occured" );
    });


function mostrarAcciones(){
	document.getElementById('GraficoAcciones').style.display = 'block';
	document.getElementById('GraficoProyectos').style.display = 'none';
}

function mostrarProyectos(){
	document.getElementById('GraficoAcciones').style.display = 'none';
	document.getElementById('GraficoProyectos').style.display = 'block';
}

</script>
@endsection