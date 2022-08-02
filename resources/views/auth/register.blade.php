@extends('layout')

@section('content')

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2>Registrarse</h2>
				@include('partials/errors')
				@include('partials/success')
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-2">

			<a href="redirect/facebook" class="btn btn-block btn-social btn-facebook btn-lg">
			    <span class="fa fa-facebook"></span> Acceder con Facebook
			</a>
			<a href="" class="btn btn-block btn-social btn-twitter btn-lg">
			    <span class="fa fa-twitter"></span> Acceder con Twitter
			</a>
			<!-- <a href="" class="btn btn-block btn-social btn-google btn-lg">
			    <span class="fa fa-google"></span> Acceder con Google
			</a> -->
			<br>

		</div>

		<div class="col-md-4 divider-left">
			<p>O con su correo electrónico:</p>
			<form role="form" method="POST" action="{{ route('register') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				{!! htmlScriptTagJsApi(['action' => 'homepage']) !!}
				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.name')</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.email')</label>
					<input type="email" class="form-control" name="email" value="{{ old('email') }}">
				</div>

				<div class="form-group">
					<label class="control-label">Distrito <a href="https://www.google.com/maps/d/u/0/viewer?ll=-31.552792999999998%2C-60.70838900000001&spn=0.102398%2C0.222473&t=m&msa=0&z=12&source=embed&ie=UTF8&iwloc=0004da28cd59655d04330&mid=1LGfSSm_S_DPnLAWRYg25YLj_CDM" target="_blank">(Ver mapa)</a></label>
					<select class="form-control" name="district" value="{{ old('district') }}">
					    <option>Centro</option>
					    <option>Este</option>
					    <option>La costa</option>
					    <option>Norte</option>
					    <option>Noreste</option>
					    <option>Noroeste</option>
					    <option>Oeste</option>
					    <option>Suroeste</option>
					  </select>
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.password')</label>
					<input type="password" class="form-control" name="password">
				</div>

				<div class="form-group">
					<label class="control-label">@lang('validation.attributes.password_confirmation')</label>
					<input type="password" class="form-control" name="password_confirmation">
				</div>
				{{-- 
				<div class="form-group">
					{!! Recaptcha::render() !!}
				</div> --}}

				<div class="form-group">
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span> @lang('auth.register_button')
					</button>
				</div>
			</form>
		</div>
	</div>
	<br>
</div>
@endsection