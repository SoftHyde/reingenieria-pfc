@for ($i = 0; $i < count($actions); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($actions))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<img class="card-img-top img-fluid" align="center" src="{{$actions[$j]->avatar}}" alt="Card image cap">
				<div class="card-block">
					<div class="row">
						<div class="col-md-8">
							<h3 class="card-title" style="color: black; margin-top:5px">{{ $actions[$j]->title }}</h3>
						</div>
						<div class="col-md-4" align="right">
							{{-- @foreach ($projects[$j]->projectTag as $tag)
								<span class="tag tag-default"> 
									<a href="{{ route('projectTag', ['tag' => $tag->tag]) }}" style="text-decoration: none; color:aliceblue">{{$tag->tag->name}}</a>
								</span>
							@endforeach --}}
							<span class="tag"> Salud
							</span>
						</div>
					</div>
					<span style="color: black;">{{ strip_tags(substr($actions[$j]->description, 0, 150)) }}...</span>
				</div>
				<div class="row" align="center">
					<p><a class="btn btn-primary btn-lg" href="{{ route('action', ['id' => $actions[$j]->id]) }}">Ver mas</a></p>
				</div>
			</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $actions->render() !!}