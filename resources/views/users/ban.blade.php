@extends('layout')

@section('content')

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<h2>Suspender usuario <small><a href="{{route('user', $user->id)}}">({{$user->name}})</a></small></h2>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col col-md-6 col-md-offset-3">
			<form role="form" method="POST" action="{{route('user.putban', $user->id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PUT">
				<div class="form-group">
					<label>Motivo</label>
					<br>
					<span>Aquí se debe explicar por qué se suspende al usuario. El mismo será notificado por correo electrónico.</span>
					<textarea class="form-control" rows="5" name="ban_reason" required>{{$user->ban_reason}}</textarea>
				</div>
				<div class="form-group">
					<label>Tiempo (días)</label>
					<br>
					<input type="number" name="quantity" min="1" max="90">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" style="margin-right: 15px;">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection