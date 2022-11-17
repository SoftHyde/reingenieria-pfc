@extends('layout')

@section('content')
<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2>{{ $project->name }}</h2>
				<div class="panel panel-default">
					<div class="panel-heading">Nuevo articulo</div>
					<div class="panel-body">
						@include('partials/errors')

						<form class="form-horizontal" role="form" method="POST" action="{{ route('create-article') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="project_id" value="{{ $project->id }}">


							<div class="form-group">
								<label class="col-md-2 control-label">Contenido</label>
								<div class="col-md-10">
									<textarea class="form-control" rows="8" name="description" required>{{old('description')}}</textarea>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-2">
									<button type="submit" class="btn btn-default" style="margin-right: 15px;">
										Publicar articulo
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>



@endsection