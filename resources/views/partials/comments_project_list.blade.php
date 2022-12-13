@foreach($comments as $comment)
@if($comment->reported <5)
	<div class="card">
		<div class="card-block"> 
			<div class="row">
				<div class="col col-md-3" align="center">
					<img class="img-circle img-msmall" src="{{$comment->user->avatar}}">
					<br>
					<a href="{{route('user', $comment->user->id)}}">{{ $comment->user->name }}</a>
					<br>
					<small>{{$comment->updated_at}}</small>
				</div>
				<div class="col col-md-8" style="padding-left: 0px;">
					<div class="proposal-comment">{{$comment->comment}}</div>
					
				</div>
				<div class="col col-md-1">
					@if(Gate::allows('edit_comment_project', $comment))
						<div class="dropdown pull-right">
						  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
						  	<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
						  </button>
						  <ul class="dropdown-menu">
						    <li>
						    	<a href="{{route('commentproject.edit',[$comment->id])}}"><i class="fa fa-edit" aria-hidden="true"></i> Editar comentario</a>
						    </li>
						    <li role="separator" class="divider"></li>
						    <li>
						    	<form role="form" method="POST" action="{{ route('commentproject.delete')}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="comment_id" value="{{ $comment->id }}">
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
			<div class="row">
				<br>
				<div class="col col-md-3 col-md-offset-3" style="padding-left: 0px;">
					@if($comment->user->name != Auth::user()->name)
						<a href="{{route('commentproject.report',[$comment->id])}}" 
						data-toggle="confirmation"
						data-popout="true"
						data-placement="bottom"
						data-btn-ok-label="Si"
						data-btn-cancel-label="No"
						data-title="¿Deseas denunciar este comentario?">
							Denunciar <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
						</a>
					@endif
				</div>
				<div id="likes_section" class="col col-md-6" align="right">
				@if($project->countdown()>0)
					@if(Gate::allows('like_comment_project', $comment))
						<form id="like_comment{{$comment->id}}" role="form" method="POST" onsubmit="likeCommentProject({{$comment->id}})" action="{{ route('commentproject.like')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="comment_id" value="{{ $comment->id }}">
							
							<button type="submit" class="btn btn-default">
							  <i class="fa fa-heart-o" aria-hidden="true"></i>
							  &nbsp;
							  <span class="proposal-text nlikes{{$comment->id}}"> {{count($comment->likers)}}</span>
							</button>
						</form>
						<form class="hidden unlike_comment" id="unlike_comment{{$comment->id}}" role="form" method="POST" onsubmit="unlikeCommentProject({{$comment->id}})" action="{{ route('commentproject.unlike')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="comment_id" value="{{ $comment->id }}">
							<input type="hidden" name="_method" value="DELETE">
							
							<button type="submit" class="btn btn-default">
							  <i class="fa fa-heart" aria-hidden="true" style="color: #ff5555;"></i>
							  &nbsp;
							  <span class="proposal-text nlikes{{$comment->id}}"> {{count($comment->likers)}}</span>
							</button>
						</form>
					@elseif(Auth::check())
						<form class="unlike_comment" id="unlike_comment{{$comment->id}}" role="form" method="POST" onsubmit="unlikeCommentProject({{$comment->id}})" action="{{ route('commentproject.unlike')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="comment_id" value="{{ $comment->id }}">
							<input type="hidden" name="_method" value="DELETE">
							
							<button type="submit" class="btn btn-default">
							  <i class="fa fa-heart" aria-hidden="true" style="color: #ff5555;"></i>
							  &nbsp;
							  <span class="proposal-text nlikes{{$comment->id}}"> {{count($comment->likers)}}</span>
							</button>
						</form>
						<form class="hidden" id="like_comment{{$comment->id}}" class="like_comment" role="form" method="POST" onsubmit="likeCommentProject({{$comment->id}})" action="{{ route('commentproject.like')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="comment_id" value="{{ $comment->id }}">
							
							<button type="submit" class="btn btn-default">
							  <i class="fa fa-heart-o" aria-hidden="true"></i>
							  &nbsp;
							  <span class="proposal-text nlikes{{$comment->id}}"> {{count($comment->likers)}}</span>
							</button>
						</form>
					@else
						<i class="fa fa-heart" aria-hidden="true" style="color: #ff5555;"></i>
						&nbsp;	
						<span class="proposal-text">{{count($comment->likers)}}</span>
					@endif
				@else
					<i class="fa fa-heart" aria-hidden="true" style="color: #ff5555;"></i>
					&nbsp;	
					<span class="proposal-text">{{count($comment->likers)}}</span>	
				@endif
				</div>
			</div>
		</div>
	</div>
	<br>
@endif
@endforeach
<hr>