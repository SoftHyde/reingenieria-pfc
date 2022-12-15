@for ($i = 0; $i < count($projects); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($projects))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<img class="card-img-top img-fluid" align="center" src="/images/proposal.jpg" alt="Card image cap">
				<div class="card-block">
					<div class="row">
						<div class="col-md-11">
							<span style="color: red; margin-top:5px">{{$projects[$j]->countdown()}} Dias restantes</span>
						</div>
					</div>
					<div class="row" align="center" style="margin-top: 10px">
						<div class="col-md-12">
							@foreach ($projects[$j]->projectTag as $tag)
								<span class="tag tag-default"> 
									<a href="{{ route('projectTag', ['tag' => $tag->tag]) }}" style="text-decoration: none; color:white">{{$tag->tag->name}}</a>
								</span>
							@endforeach
						</div>
					</div>
					<h3 class="card-title" style="color: black; margin-top:10px">{{ $projects[$j]->name }}</h3>
					<span style="color: black;">{{ strip_tags(substr($projects[$j]->description, 0, 150)) }}...</span>
				</div>
				<div class="row" align="center">
					<p><a class="btn btn-primary btn-lg" href="{{ route('project', ['id' => $projects[$j]->id]) }}">Ver mas</a></p>
				</div>
			</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $projects->links() !!}