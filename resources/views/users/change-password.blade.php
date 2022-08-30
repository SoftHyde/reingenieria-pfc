@extends('layout')


@section('content')


<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<h2>Cambiar contraseña</h2>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			@include('partials/success')
			@include('partials/errors')

			<form role="form" method="POST" action="{{route('user.post-change-password')}}">
			  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
			  	<input type="hidden" name="_method" value="PUT">

			  	<div class="form-group">
			    	<label for="current_password">Contraseña actual</label>
			    	<input type="password" name="current_password" value="" class="form-control">
			  	</div>

			  	<div class="form-group">
			    	<label for="new_password">Nueva contraseña</label>
			    	<input type="password" name="new_password" value="" class="form-control">
			  	</div>

			  	<div class="form-group">
			    	<label for="new_password_confirmation">Confirmar nueva contraseña</label>
			    	<input type="password" name="new_password_confirmation" value="" class="form-control">
			  	</div>

			  	<div>
					<button type="submit" class="btn btn-primary">
				    	Cambiar contraseña
				  	</button>
				</div>
			</form>
		</div>
	</div>
</div>

