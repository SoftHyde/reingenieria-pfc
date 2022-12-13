@extends('layout')

@section('content')

<section class="gray">
	<div class="jumbotron">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-6 col-md-offset-3">
					<h2>Editar comentario</h2>
					Publicado en <a href="{{route('project', $comment->project->id)}}">{{$comment->project->name}}</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<form role="form" method="POST" action="{{route('commentproject.update', $comment->id)}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="_method" value="PUT">

					<div class="form-group">
						<textarea class="form-control" rows="5" name="comment" required>{{$comment->comment}}</textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" style="margin-right: 15px;">Enviar</button>
					</div>
				</form>

				<form role="form" method="POST" action="{{ route('commentproject.delete')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="comment_id" value="{{ $comment->id }}">
					<input type="hidden" name="_method" value="DELETE">
					<button type="submit" class="btn btn-danger btn-block rect"
					data-toggle="confirmation"
					data-popout="true"
					data-placement="bottom"
					data-btn-ok-label="Si"
					data-btn-cancel-label="No"
					data-title="¿Estás seguro de que deseas eliminarlo?"
					><i class="fa fa-trash" aria-hidden="true"></i> Eliminar comentario
					</button>
				</form>
			</div>
		</div>
	</div>
</section>


@endsection