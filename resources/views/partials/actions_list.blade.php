@for ($i = 0; $i < count($actions); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($actions))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('action', ['id' => $actions[$j]->id]) }}">
					<img class="card-img-top img-fluid" align="center" src="{{$actions[$j]->avatar}}" alt="Card image cap">
			    	<div class="card-block">
			    		<div class="row">
							<div class="col-md-8">
								<h3 class="card-title" style="color: black; margin-top:5px">{{ $actions[$j]->title }}</h3>
							</div>
							<div class="col-md-2 col-md-offset-2" style="margin-top:7px">
								<span class="tag"> Salud
								</span>
							</div>
						</div>
			    		<span style="color: black;">{{ strip_tags(substr($actions[$j]->description, 0, 150)) }}...</span>
			    	</div>
			    </a>
			</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $actions->render() !!}