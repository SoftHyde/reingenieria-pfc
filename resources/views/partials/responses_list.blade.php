@foreach($comment->responses as $response)
	<div class="row">
		<div class="col col-md-1" align="center">
			<img class="img-circle img-xsmall" src="{{$response->user->avatar}}">
		</div>
		<div class="col col-md-10" style="padding-left: 0px; margin-left: 0px; margin-right: 0px; padding-right: 0px;">
			<a href="{{route('user', $response->user->id)}}"><strong>{{ $response->user->name }}</strong></a> {{$response->comment}}
			<br>
			<small>{{$response->updated_at}}</small>
		</div>
		<div class="col col-md-1">
			@if(Gate::allows('edit_comment', $response))
				<div class="dropdown pull-right">
				  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
				  	<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
				  </button>
				  <ul class="dropdown-menu">
				    <li>
				    	<a href="{{route('comment.edit', $response->id)}}"><i class="fa fa-edit" aria-hidden="true"></i> Editar comentario</a>
				    </li>
				    <li role="separator" class="divider"></li>
				    <li>
				    	<form role="form" method="POST" action="{{ route('comment.delete')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="comment_id" value="{{ $response->id }}">
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger btn-block rect"
							data-toggle="confirmation"
							data-popout="true"
							data-placement="bottom"
							data-btn-ok-label="Si"
					        data-btn-cancel-label="No"
					        data-title="¿Estás seguro de que deseas eliminarlo?"
							><i class="fa fa-trash" aria-hidden="true"></i> Eliminar comentario
							</button>
						</form>
				    </li>
				  </ul>
				</div>
			@endif
		</div>
	</div> 
	<hr>
@endforeach