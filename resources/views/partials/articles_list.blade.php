@for ($i = 0; $i < count($articles); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($articles))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('article', ['id' => $articles[$j]->id]) }}">
					<img class="card-img-top img-fluid" align="center" src="/images/proposal.jpg" alt="Card image cap">
			    	<div class="card-block">
			    		<h3 class="card-title" style="color: black;">Articulo: {{$j+1}}</h3>
			    		<span style="color: black;">{{ strip_tags(substr($articles[$j]->description, 0, 100)) }}...</span>
	    				<div class="row" style="color: black;">
	    					<div class="col-md-8">
	    						<br>
								
				    		</div>
			    		</div>
			    			
			    	</div>
			    </a>
	    	</div>
		@endif
		<hr>
	@endfor
	</div>
	<hr>
@endfor

{!! $articles->render() !!}