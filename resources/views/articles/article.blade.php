@extends('layout')

<!-- Description -->
<meta name="description" content="{{$article->title}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$article->title}}">
<meta itemprop="image" content="http://pfc.local/images/article.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$article->title}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/proposal.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/proposal.jpg" />
<meta property="og:description" content="{{$article->title}}" />

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
		  	<h2>
				<a href="{{ route('project', ['id' => $project->id]) }}"><small>{{$project->name}}</small> </a> <small> >> Articulo {{$numero}}</small>
				<br>
				{{ $article->title }}
			</h2>
			<p class="proposal-text">{{$article->description}}</p>
			<br>
			<strong>COMPARTIR</strong>
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
					@if(Gate::allows('support_article', $article->supporters()))
						<form role="form" method="POST" action="{{ route('article.support')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="article_id" value="{{ $article->id }}">
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
						<form role="form" method="POST" action="{{ route('article.unsupport')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="article_id" value="{{ $article->id }}">
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
						Última edición: {{$article->updated_at}}
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
				  @include('partials/comments_article_list')
				  	@if(Auth::check())
					  	<ul class="nav nav-tabs">
					    	<li class="active"><a href="#"> Comentar </a></li>
					  	</ul>
						<form class="form-horizontal" role="form" method="POST" action="{{ route('article.comment')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							
							<input type="hidden" name="article_id" value="{{ $article->id }}">
						

							<div class="form-group">
								<div class="col col-md-12">
									<textarea class="form-control" rows="5" name="comment" required>{{old('comment')}}</textarea>
									<input type="hidden" name="numero" value="{{ $numero }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col col-md-12">
									<button type="submit" class="btn btn-default" style="margin-right: 15px;">
									Publicar comentario
									</button>
								</div>
							</div>
						</form>
					@else
						<p class="text-muted" align="center">Inicia sesión para comentar</p>
					@endif
			</div>
		</div>
	</div>
</div>	
@endsection

@section('scripts')
<script src="/js/like_comment.js"></script>
<script src="/js/unlike_comment.js"></script>
<script src="/js/like_comment_article.js"></script>
<script src="/js/unlike_comment_article.js"></script>
@endsection
