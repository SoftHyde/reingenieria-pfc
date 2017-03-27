@extends('layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h2>
				<a href="{{ route('action', ['id' => $action->id]) }}"><small>{{$action->title}} >> </small> </a>
				<br>
				{{ $proposal->title }}
			</h2>
		  	<ul class="nav nav-tabs">
		    	<li class="active"><a href="#"> <h4>Propuesta</h4> </a></li>
		  	</ul>
		  	<div class="panel panel-default">
		  		<div class="panel-body"> 
		  			{{ $proposal->content }}
		  			<hr>
		  			<span class="text-muted pull-right">
		  				Creado por <a href="">{{$creator->name}}</a>. 
		  				<br>
		  				Última edición: {{$proposal->updated_at}}
		  			</span>
		  		</div>
		  	</div>

		  	@include('partials/errors')
		  	@include('partials/success')
		  	<h3>Comentarios</h3>
		  	<ul class="nav nav-tabs">
		    	<li class="active"><a href="#"> Comentar </a></li>
		  	</ul>

			<form class="form-horizontal" role="form" method="POST" action="{{ route('proposal.comment')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

				<div class="form-group">
					<div class="col-md-12">
						<textarea class="form-control" rows="5" name="comment" required>{{old('comment')}}</textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col" align="right">
						<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
						Publicar comentario
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>

@endsection