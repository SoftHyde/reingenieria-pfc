@for ($i = 0; $i < count($projects); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($projects))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('project', ['id' => $projects[$j]->id]) }}">
					<img class="card-img-top img-fluid" align="center" src="/images/proposal.jpg" alt="Card image cap">
			    	<div class="card-block">
						<div class="row">
							<div class="col-md-8">
								<span style="color: red; margin-top:5px">{{$projects[$j]->countdown()}} Dias restantes</span>
							</div>
							<div class="col-md-2 col-md-offset-2">
								<span class="tag"> Salud
								</span>
							</div>
						</div>
			    		<h3 class="card-title" style="color: black; margin-top:10px">{{ $projects[$j]->name }}</h3>
			    		<span style="color: black;">{{ strip_tags(substr($projects[$j]->description, 0, 150)) }}...</span>
			    	</div>
			    </a>
			</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $projects->links() !!}