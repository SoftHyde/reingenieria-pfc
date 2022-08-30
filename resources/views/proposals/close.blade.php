@extends('layout')

@section('content')

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<h2>Cerrar propuesta <small><a href="{{route('proposal', $proposal->id)}}">({{$proposal->title}})</a></small></h2>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col col-md-6 col-md-offset-3">
			<form role="form" method="POST" action="{{route('proposal.putclose', $proposal->id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PUT">
				<div class="form-group">
					<label>Mensaje de cierre</label>
					<br>
					<span>Aquí se debe explicar por qué se cierra la propuesta. En caso de que se trate de una propuesta repetida se puede incluir el link a la propuesta original.</span>
					<textarea class="form-control" rows="5" name="closing_message" required>{{$proposal->closing_message}}</textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" style="margin-right: 15px;">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection