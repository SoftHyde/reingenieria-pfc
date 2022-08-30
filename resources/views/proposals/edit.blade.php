@extends('layout')

@section('content')

<section class="gray">
	<div class="jumbotron">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-6 col-md-offset-3">
					<h2>Editar <a href="{{route('proposal', $proposal->id)}}">{{$proposal->title}}</a> </h2>

					Publicado en <a href="{{route('action', $proposal->action_id)}}">{{$proposal->action->title}}</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<form role="form" method="POST" action="{{route('proposal.update', $proposal->id)}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="_method" value="PUT">
					<div class="form-group">
						<label>Título</label>
						<input type="text" name="title" class="form-control" value="{{$proposal->title}}" required>
					</div>
					<div class="form-group">
						<label>Contenido</label>
						<textarea id="summernote" class="form-control" rows="5" name="content" required>{{$proposal->content}}</textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" style="margin-right: 15px;">Enviar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>


@endsection