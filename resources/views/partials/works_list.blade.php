@for ($i = 0; $i < count($action->works()); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($action->works()))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('works', $action->works()[$j]->id )}}">
					<img class="card-img-top img-fluid" align="center" src="/images/works.jpg" alt="Card image cap">
			    	<div class="card-block">
			    		<h3 class="card-title" style="color: black;">{{ $action->works()[$j]->title }}</h3>
			    		<span style="color: black;">{{ strip_tags(substr($action->works()[$j]->content, 0, 150)) }}...</span>
			    	</div>
			    </a>
	    	</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $action->works()->render() !!}
