@extends('layout')

@section('content')

<section class="gray">
	<div class="jumbotron">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-6 col-md-offset-3">
					<h2>Editar <a href="{{route('article', [$article->id,$numero])}}"></a> </h2>

					Publicado en <a href="{{route('project', $article->project_id)}}">{{$article->project->name}}</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-6 col-md-offset-3">
				<form role="form" method="POST" action="{{route('article.update', [$article->id,$numero])}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="_method" value="PUT">
					<div class="form-group">
						<label>Contenido</label>
						<textarea class="form-control" rows="5" name="description" required>{{$article->description}}</textarea>
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