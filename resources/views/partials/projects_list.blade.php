@for ($i = 0; $i < count($projects); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($projects))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('project', ['id' => $projects[$j]->id]) }}">
			    	<div class="card-block">
			    		<h3 class="card-title" style="color: black;">{{ $projects[$j]->name }}</h3>
			    		<span style="color: black;">{{ strip_tags(substr($projects[$j]->description, 0, 150)) }}...</span>
			    	</div>
			    </a>
				<span style="color: red; padding-left:10px;">{{$projects[$j]->countdown()}} Dias restantes</span>

			</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $projects->render() !!}