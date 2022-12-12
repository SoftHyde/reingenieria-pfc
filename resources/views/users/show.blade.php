@extends('layout')

@section('meta')
<!-- Description -->
<meta name="description" content="{{$user->name}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$user->name}}">
<meta itemprop="image" content="http://pfc.local/images/profile.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$user->name}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/profile.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/profile.jpg" />
<meta property="og:description" content="{{$user->name}}" />
@endsection

@section('content')

<div class="ssk-sticky ssk-left ssk-center ssk-lg">
    <a href="" class="ssk ssk-facebook"></a>
    <a href="" class="ssk ssk-twitter"></a>
    <a href="" class="ssk ssk-google-plus"></a>
    <a href="" class="ssk ssk-pinterest"></a>
    <a href="" class="ssk ssk-tumblr"></a>
</div>

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="row">
			<div class="col-md-4 col-md-offset-4" align="center">
				<img class="img-fluid img-circle" src="{{$user->avatar}}" alt="Foto de perfil">
				<h2>{{$user->name}}</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6" align="right">
				<p>
					Propuestas publicadas: <strong>{{count($user->proposals)}}</strong>
					<br>
					Comentarios realizados: <strong>{{count($user->comments)}}</strong>
					<br>
					Obras calificadas: <strong>{{count($user->ratings)}}</strong>
				</p>
				@include('partials/success')
				@include('partials/warning')
				@include('partials/errors')
			</div>
			<div class="col-md-6" align="left">
				<p>
					Propuestas publicadas: <strong>{{count($user->proposals)}}</strong>
					<br>
					Comentarios realizados: <strong>{{count($user->comments)}}</strong>
					<br>
					Obras calificadas: <strong>{{count($user->ratings)}}</strong>
				</p>
				@include('partials/success')
				@include('partials/warning')
				@include('partials/errors')
			</div>
		</div>
		@if(Gate::allows('config_profile', $user->id))
			<div class="col-md-1" align="center">
				<div class="dropdown">
				  	<button class="btn btn-modern dropdown-toggle btn-lg" type="button" data-toggle="dropdown">
				  		<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
				  		Ajustes
				  	</button>
				  	<ul class="dropdown-menu">
				  		@if(Gate::allows('edit_profile', $user->id))
					    	<li>
					    		<a href="{{route('user.edit')}}">
					    			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar perfil
					    		</a>
					    	</li>
				    	@endif
				    	@if(Gate::allows('admin') and $user->id != Auth::user()->id)
				    		<li>
				    			@if($user->ban_reason != null)
						    		<a href="{{route('user.unban', $user->id)}}">
						    			<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Quitar suspensión
						    		</a>
						    	@else
						    		<a href="{{route('user.ban', $user->id)}}" class="btn btn-danger btn-block rect">
						    			<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Suspender usuario
						    		</a>
						    	@endif
					    	</li>
				    	@endif
				    </ul>
				</div>
			</div>
		@endif
	</div>
</div>
<br>

<div class="jumbotron jumbottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				
				@if(count($user->proposals) > 0)
					<h3>Propuestas publicadas</h3>
					<br>
				  	@for ($i = 0; $i < count($user->proposals); $i=$i+3)
						<div class="card-deck">
						@for ($j = $i; $j < $i+3; $j++)
							@if($j >= count($user->proposals))
								<div class="card card-holder"></div>
							@else
								<div class="card">
									<a href="{{ route('proposal', ['id' => $user->proposals[$j]->id]) }}">
										<img class="card-img-top img-fluid" align="center" src="/images/proposal.jpg" alt="Card image cap">
								    	<div class="card-block">
								    		<h4 class="card-title" style="color: black;">{{ $user->proposals[$j]->title }}</h4>
								    	</div>
								    </a>
						    	</div>
							@endif
							<hr>
						@endfor
						</div>
						<br>
					@endfor
				@endif
				
				@if(count($user->comments) > 0)
					<br>
					<hr class="styled">
				  	<h3>Comentarios realizados</h3>
				  	<br>
				  	@foreach($user->comments as $comment)
				  		<div class="card">
							<div class="card-block"> 
								En <a href="{{ route('proposal', ['id' => $comment->proposal->id]) }}">{{ $comment->proposal->title }}</a>
								@if(Gate::allows('edit_comment', $comment))
									<div class="dropdown pull-right">
									  <button class="btn btn-modern dropdown-toggle" type="button" data-toggle="dropdown">
									  	<span class="caret"></span></button>
									  </button>
									  <ul class="dropdown-menu">
									    <li>
									    	<a href="">Editar comentario</a>
									    </li>
									    @if(Gate::allows('admin_action', $comment->proposal->action_id))
										    <li role="separator" class="divider"></li>
										    <li>
										    	<form role="form" method="POST" action="{{ route('comment.delete')}}">
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
													>
													  Eliminar comentario
													</button>
												</form>
										    </li>
										   @endif
									  </ul>
									</div>
								@endif
								<br>
								<small>{{$comment->updated_at}}</small>
								<br>
								<div class="proposal-comment">{{$comment->comment}}</div>
								<hr>
								<div align="right">
									<i class="fa fa-heart" aria-hidden="true" style="color: #ff5555;"></i>
									&nbsp;	
									<span class="proposal-text">{{count($comment->likers)}}</span>
								</div>
							</div>
						</div>
						<br>
				  	@endforeach
				@endif

				@if(count($user->ratings) > 0)
					<br>
					<hr class="styled">
				  	<h3>Calificaciones</h3>
				  	<br>
				  	@foreach($user->ratings as $rating)
						<div class="card">
							<div class="card-block"> 
								@for($i=0; $i < $rating->stars; $i++)
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								@endfor
								@for($i=$rating->stars; $i < 5; $i++)
									<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
								@endfor
								<br>
								<div class="proposal-comment">{{$rating->comment}}</div>
								<hr>
								<div class="pull-right">
									En <a href="{{ route('works', $rating->work->id )}}">{{ $rating->work->title }}</a>
									<br>
									<small>{{$rating->updated_at}}</small>
								</div>
							</div>
						</div>
						<br>
					@endforeach
				@endif

			</div>
		</div>
	</div>
</div>

@endsection
