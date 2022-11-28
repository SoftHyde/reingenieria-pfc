<div class="list-group">
	@for ($i = 0; $i < count($articles); $i=$i+1)
		@if($i >= count($articles))
			<div class="card card-holder"></div>
		@else
			<a href="{{ route('article', ['id' => $articles[$i]->id, 'numero'=>$i+1]) }}" class="list-group-item">
				<div class="row">
					<div class="col-md-10">
						<h3 style="color: black; margin: 10px">Articulo: {{$i+1}}</h3>
						<span style="color: black; margin-left: 10px">{{ strip_tags(substr($articles[$i]->description, 0, 150)) }}...</span>
					</div>
					<div class="col-md-2" style="align-items: center !important;">
						<h3 class="light" align="right" style="color: #555">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
							{{count($articles[$i]->supporters)}}	
						</h3>
					</div>
				</div>
			</a>
		@endif
	@endfor
</div>

@if (Auth::check() and Auth::user()->role == 'moderador')
<div class="row text-center">
	<a href="{{ route('create-article-form', ['project_id' => $project->id]) }}" class="btn btn-modern btn-lg">Crear Articulo</a>
</div>
@endif


{!! $articles->render() !!}