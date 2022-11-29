@extends('layout')

@section('meta')

<!-- Description -->
<meta name="description" content="{{$project->name}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$project->name}}">
<meta itemprop="image" content="http://pfc.local/images/action.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$project->name}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/action.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/action.jpg" />
<meta property="og:description" content="{{$project->name}}" />

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/bower_components/slick-carousel/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/bower_components/slick-carousel/slick/slick-theme.css"/>
@endsection



@section('content')

<div class="jumbotron no-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-8">
						<h1 class="normal">
							{{ $project->name }}
						</h1>
					</div>
				</div>
				<br>	
				<div class="col-md-2">
					@if(Gate::allows('admin'))
						<div class="dropdown">
						  <button class="btn btn-modern dropdown-toggle btn-lg" type="button" data-toggle="dropdown">Administrar
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
							<li role="separator" class="divider"></li>
							<li class="dropdown-header">Proyecto:</li>
							<li>
								  <a href="{{route('project.edit', $project->id)}}">
									  <i class="fa fa-edit" aria-hidden="true"></i> Editar
								  </a>
							  </li>

							
								<li role="separator" class="divider"></li>
								<li>
									<form role="form" method="POST" action="{{ route('project.delete')}}">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="project_id" value="{{ $project->id }}">
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-danger btn-block rect"
										data-toggle="confirmation"
										data-popout="true"
										data-placement="bottom"
										data-btn-ok-label="Si"
										data-btn-cancel-label="No"
										data-title="¿Estás seguro de que deseas eliminarla?"
										>
										  <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar Proyecto
										</button>
									</form>
								</li>
							
						  </ul>
						</div>
					@endif
				</div>
				<ul class="nav nav-tabs">
	  				<li class="active"><a href="#">Descripción</a></li>
	  				@if(count($articles)>0)
	  					<li><a href="#" class="scroll-link" data-id="propuestas">Articulos</a></li>
	  				@endif
	  			</ul>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
	  		<p>{{$project->description}}</p>
	  		<hr>
	  		<strong>COMPARTIR</strong>
	  		<div class="ssk-group">
			    <a href="" class="ssk ssk-facebook"></a>
			    <a href="" class="ssk ssk-twitter"></a>
			    <a href="" class="ssk ssk-google-plus"></a>
			    <a href="" class="ssk ssk-pinterest"></a>
			    <a href="" class="ssk ssk-tumblr"></a>
			</div>
			<strong>TAGS</strong>
	  		<div>
			    @foreach($project->projectTag as $tag)
				<a href="{{ route('projectTag', ['tag' => $tag->tag]) }}">{{$tag->tag->name}}</a>
				|
				@endforeach
			</div>
			<br>
		</div>
	</div>
</div>


@if(count($articles) > 0 )
<div class="jumbotron no-margin-bottom page-section" id="propuestas">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2 class="light">
					Articulos <a href="#" class="scroll-top back-to-top btn btn-modern pull-right"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>
				</h2>
				<br />
				@include('partials/articles_list')
			</div>
		</div>
	</div>
</div>
@else
@if (Auth::check() and (Gate::allows('moderator', $project)))
{{-- Agregar condicion para chekear en vez de el rol, el mail de usuarios asignados al proyecto como moderadores --}}
<div class="row text-center">
	<a href="{{ route('create-article-form', ['project_id' => $project->id]) }}" class="btn btn-modern btn-lg">Crear Articulo</a>
</div>
@else
<div class="row text-center">
	<p>No hay articulos creados aun.</p>
</div>
@endif

@endif

@endsection

@section('scripts')
<script src="/js/scroll.js"></script>
<script src="/js/button_block.js"></script>
<script src="/js/reload_poll.js"></script>

<script type="text/javascript" src="/bower_components/slick-carousel/slick/slick.min.js"></script>

<script type="text/javascript">
    $('.autoplay').slick({
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  autoplay: true,
	  autoplaySpeed: 2000,
	  dots: true,
	  responsive: [
                    {
                      breakpoint: 800,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 500,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }

                  ]
	});
</script>

@endsection