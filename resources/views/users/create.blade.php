@extends('layout')

@section('content')

<div class="jumbotron">
	<div class="container fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h2>Crear usuario</h2>
			</div>
		</div>
	</div>
</div>

<div class="container fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">	
			@include('partials/errors')

			<form role="form" method="POST" enctype="multipart/form-data" action="{{ route('user.postcreate') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.name')</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.email')</label>
					<input type="email" class="form-control" name="email" value="{{ old('email') }}">
				</div>

				<div class="form-group">
				  	<label class="control-label" for="role">Tipo de usuario</label>
				  	<select class="form-control" id="role" name="role" value="{{ old('role') }}">
				    	<option>general</option>
				    	<option>admin</option>
				  	</select>
				  	<br>
				  	<div class="alert alert-danger"><strong>¡Cuidado! </strong>Si creas un usuario tipo 'admin', le darás acceso a todas las funciones de administrador.</div>
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.password')</label>
					<input type="password" class="form-control" name="password">
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.password_confirmation')</label>
					<input type="password" class="form-control" name="password_confirmation">
				</div>

				<div class="form-group">
					{!! Recaptcha::render() !!}
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Crear
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection