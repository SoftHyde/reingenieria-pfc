@extends('layout')


@section('content')


<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h2>Editar perfil <small><a href="{{route('user', $user->id)}}">({{$user->name}})</a></small></h2>
				Si desea cambiar su contraseña diríjase a 
				<a href="{{route('user.change-password')}}">Cambiar contraseña</a>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">

			@include('partials/success')
			@include('partials/errors')

			<form role="form" enctype="multipart/form-data" method="POST" action="{{route('user.update', $user->id)}}">
			  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
			  	<input type="hidden" name="_method" value="PUT">

			  	<div class="form-group">
			    	<label for="avatar">Avatar</label>
			    	<div class="alert alert-info">
			    		<div class="row">
				    		<div class="col-md-9 bottom-column">	
			    				<strong>Subir un archivo</strong>
			    				<br>
			    				<p>(La imagen debe ser cuadrada para su correcta visualización)</p>
			    				<input type="file" name="avatar">
				    		</div>

				    		<div class="col-md-3">
				    			<br>
				    			<img class="img-fluid img-rounded img-small" src="{{$user->avatar}}" alt="Foto de perfil">		
				    		</div>
				    	</div>
			    	</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="name">Nombre</label>
			    	<input type="text" name="name" value="{{$user->name}}" class="form-control">
			  	</div>
			  	
			  	<div class="form-group">
			    	<label for="email">Email</label>
			    	<input type="email" name="email" value="{{$user->email}}" class="form-control">
			  	</div>

			  	<div class="form-group">
					<label class="control-label">Distrito <a href="https://www.google.com/maps/d/u/0/viewer?ll=-31.552792999999998%2C-60.70838900000001&spn=0.102398%2C0.222473&t=m&msa=0&z=12&source=embed&ie=UTF8&iwloc=0004da28cd59655d04330&mid=1LGfSSm_S_DPnLAWRYg25YLj_CDM" target="_blank">(Ver mapa)</a></label>
					<br>
					{{ $user->district }}
					<select class="form-control" name="district" value="{{ $user->district }}">
						<option disabled selected>Cambiar</option>
					    <option >Centro</option>
					    <option >Este</option>
					    <option >La costa</option>
					    <option >Norte</option>
					    <option >Noreste</option>
					    <option >Noroeste</option>
					    <option >Oeste</option>
					    <option >Suroeste</option>
					  </select>
				</div>

				<br>
			  	<div>
					<button type="submit" class="btn btn-default btn-lg">
				    	Guardar cambios
				  	</button>
				</div>
			</form>
		</div>
	</div>
</div>