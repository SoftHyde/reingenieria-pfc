@for ($i = 0; $i < count($proposals); $i=$i+3)
	<div class="card-deck">
	@for ($j = $i; $j < $i+3; $j++)
		@if($j >= count($proposals))
			<div class="card card-holder"></div>
		@else
			<div class="card">
				<a href="{{ route('proposal', ['id' => $proposals[$j]->id]) }}">
					<img class="card-img-top img-fluid" align="center" src="/images/proposal.jpg" alt="Card image cap">
			    	<div class="card-block">
			    		<h3 class="card-title" style="color: black;">{{ $proposals[$j]->title }}</h3>
			    		<span style="color: black;">{{ strip_tags(substr($proposals[$j]->content, 0, 100)) }}...</span>
	    				<div class="row" style="color: black;">
	    					<div class="col-md-8">
	    						<br>
				    			Comentarios: <span style="font-weight: normal;">{{count($proposals[$j]->comments)}}</span>
				    			
				    		</div>
				    		<div class="col-md-4">
				    			<h3 class="light" align="right" style="color: #555">
				    				<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
				    				{{count($proposals[$j]->supporters)}}	
				    			</h3>
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

@if($action->proposal_posters == 'general')
<div class="row text-center">
	<a href="{{ route('create-proposal-form', ['action_id' => $action->id]) }}" class="btn btn-modern btn-lg">Crear propuesta</a>
</div>
@endif

{!! $proposals->render() !!}