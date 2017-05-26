@extends('layout')

<!-- Description -->
<meta name="description" content="{{$proposal->title}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$proposal->title}}">
<meta itemprop="image" content="http://pfc.local/images/proposal.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$proposal->title}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/proposal.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/proposal.jpg" />
<meta property="og:description" content="{{$proposal->title}}" />

@section('content')

<div class="ssk-sticky ssk-left ssk-center ssk-lg">
    <a href="" class="ssk ssk-facebook"></a>
    <a href="" class="ssk ssk-twitter"></a>
    <a href="" class="ssk ssk-google-plus"></a>
    <a href="" class="ssk ssk-pinterest"></a>
    <a href="" class="ssk ssk-tumblr"></a>
</div>


<div class="jumbotron"></div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include('partials/warning')
			@include('partials/errors')
			@include('partials/success')
			@if( !$proposal->isOpened())
				<div class="alert alert-danger">
					<h3>Propuesta cerrada</h3>
					{{$proposal->closing_message}}
				</div>
			@endif
		  	<h2>
				<a href="{{ route('action', ['id' => $action->id]) }}"><small>{{$action->title}}</small> </a> <small> >> Propuesta</small>
				@if(Gate::allows('edit_proposal', $proposal))
					<div class="dropdown pull-right">
					  <button class="btn btn-modern dropdown-toggle btn-lg" type="button" data-toggle="dropdown">
					  	<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					  </button>
					  <ul class="dropdown-menu">
					    @if(Gate::allows('admin_action', $proposal->action_id))
						    @if($proposal->isOpened())
						    	<li class="list-group-item list-group-item-default">
							    	<a href="{{route('proposal.edit', $proposal->id)}}"><i class="fa fa-edit" aria-hidden="true"></i> Editar contenido de la propuesta</a>
							    </li>
							    <li class="list-group-item list-group-item-danger">
							    	<a href="{{route('proposal.getclose', $proposal->id)}}">
							    		<i class="fa fa-ban" aria-hidden="true"></i> Cerrar con comentario
							    	</a>
							    </li>
							@else
								<li class="list-group-item list-group-item-success">
							    	<a href="{{route('proposal.reopen', $proposal->id)}}">
							    		<i class="fa fa-folder-open-o" aria-hidden="true"></i> Reabrir propuesta
							    	</a>
							    </li>
								<li class="list-group-item list-group-item-danger">
							    	<a href="{{route('proposal.getclose', $proposal->id)}}">
							    		<i class="fa fa-edit" aria-hidden="true"></i> Editar comentario de cierre
							    	</a>
							    </li>
							@endif
						    <li class="divider"></li>
						    <li>
						    	<form role="form" method="POST" action="{{ route('proposal.delete')}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
									<input type="hidden" name="_method" value="DELETE">

									<button type="submit" class="btn btn-danger btn-block rect"
									style="text-align:left; padding-left: 35px" 
									data-toggle="confirmation"
									data-popout="true"
									data-placement="bottom"
									data-btn-ok-label="Si"
							        data-btn-cancel-label="No"
							        data-title="¿Estás seguro de que deseas eliminarla?"
									>
									  <i class="fa fa-ban" aria-hidden="true"></i> Eliminar propuesta
									</button>
								</form>
						    </li>
						   @endif
					  </ul>
					</div>
				@endif
				<br>
				{{ $proposal->title }}
			</h2>
			<p class="proposal-text">{!! nl2br($proposal->content) !!}</p>
			<br>
			<div class="ssk-group" >
			    <a href="" class="ssk ssk-facebook"></a>
			    <a href="" class="ssk ssk-twitter"></a>
			    <a href="" class="ssk ssk-google-plus"></a>
			    <a href="" class="ssk ssk-pinterest"></a>
			    <a href="" class="ssk ssk-tumblr"></a>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@if(Gate::allows('support_proposal', $proposal->supporters()))
						<form role="form" method="POST" action="{{ route('proposal.support')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
							<p>
								<button type="submit" class="btn btn-modern btn-lg">
								  <small>Apoyar</small>
								</button>
								&nbsp;
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
								<span class="proposal-text"> {{count($supporters)}}</span>
							</p>
						</form>
					@elseif(Auth::check())
						<form role="form" method="POST" action="{{ route('proposal.unsupport')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
							<input type="hidden" name="_method" value="DELETE">
							<p>
								<button type="submit" class="btn btn-modern btn-lg">
								  <small>Quitar apoyo</small>
								</button>
								&nbsp;
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
								<span class="proposal-text"> {{count($supporters)}}</span>
							</p>
						</form>
					@else
						<p>
						  	<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>	
							<span class="proposal-text">{{count($supporters)}}</span>
						</p>
					@endif
				</div>
				<div class="col-md-6">
					<span class="text-muted pull-right">
						Creado por <a href="{{route('user', $creator->id)}}">{{$creator->name}}</a>. 
						<br>
						Última edición: {{$proposal->updated_at}}
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<br>


<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			  	<h3><i class="fa fa-comments" aria-hidden="true"></i> Discusión</h3>
			  	@include('partials/comments_list')
			  	@if($proposal->isOpened())
				  	@if(Auth::check())
					  	<ul class="nav nav-tabs">
					    	<li class="active"><a href="#"> Comentar </a></li>
					  	</ul>
						<form class="form-horizontal" role="form" method="POST" action="{{ route('proposal.comment')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" rows="5" name="comment" required>{{old('comment')}}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col" align="right">
									<button type="submit" class="btn btn-default" style="margin-right: 15px;">
									Publicar comentario
									</button>
								</div>
							</div>
						</form>
					@else
						<p class="text-muted" align="center">Inicia sesión para comentar</p>
					@endif
				@else
					<div class="alert alert-danger">
						<h3>Propuesta cerrada</h3>
						{{$proposal->closing_message}}
					</div>
				@endif
			</div>
		</div>
	</div>
</div>	
@endsection

@section('scripts')
<script src="/js/like_comment.js"></script>
<script src="/js/unlike_comment.js"></script>
@endsection
