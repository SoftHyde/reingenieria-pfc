@extends('layout')

@section('meta')

<!-- Description -->
<meta name="description" content="{{$action->title}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$action->title}}">
<meta itemprop="image" content="http://pfc.local/images/action.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$action->title}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/action.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/action.jpg" />
<meta property="og:description" content="{{$action->title}}" />

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
						<img class="img-fluid img-circle img-small" src="{{$action->avatar}}" alt="Foto de perfil">
					</div>
					<div class="col-md-8">
						<h1 class="normal">
							{{ $action->title }}
						</h1>
					</div>
					<div class="col-md-2">
						@if(Gate::allows('admin_action', $action->admin_id))
							<div class="dropdown">
							  <button class="btn btn-modern dropdown-toggle btn-lg" type="button" data-toggle="dropdown">Administrar
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu">
							  	@if($action->allow_proposals)
							  	<li>
							    	<a href="{{ route('create-proposal-form', $action->id) }}">
							    		<i class="fa fa-bullhorn" aria-hidden="true"></i> Publicar propuesta
							    	</a>
							    </li>
							    @endif

							    @if($action->allow_works)
							    <li>
							    	<a href="{{route('work.publish', $action->id)}}">
							    		<i class="fa fa-wrench" aria-hidden="true"></i> Publicar obra del municipio
							    	</a>
							    </li>
							    @endif

							    @if($action->allow_newvents)
							    <li>
							    	<a href="{{route('new.publish', $action->id)}}">
							    		<i class="fa fa-file-text-o" aria-hidden="true"></i> Publicar noticia
							    	</a>
							    </li>
							    <li>
							    	<a href="{{route('event.publish', $action->id)}}">
							    		<i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Publicar evento
							    	</a>
							    </li>
							    @endif

							    @if($action->allow_polls)
							    	@if(is_null($action->poll))
								    <li>
								    	<a href="{{route('action.create-poll', $action->id)}}">
								    		<i class="fa fa-pie-chart" aria-hidden="true"></i> Crear Votación entre propuestas
								    	</a>
								    </li>
								    @else
								    <li role="separator" class="divider"></li>
								    <li class="dropdown-header">Votación:</li>
								    	@if($action->poll->ongoing)
									    <li>
									    	<a href="{{route('poll.end', $action->poll->id)}}"
									    		data-toggle="confirmation"
												data-popout="true"
												data-placement="bottom"
												data-btn-ok-label="Si"
										        data-btn-cancel-label="No"
										        data-title="¿Estás seguro de que deseas terminar la votación?"
												>
									    		<i class="fa fa-stop-circle-o" aria-hidden="true"></i> Terminar
									    	</a>
									    </li>
									    @endif
								    <li>
								    	<a href="{{route('poll.delete', $action->poll->id)}}"
								    		data-toggle="confirmation"
											data-popout="true"
											data-placement="bottom"
											data-btn-ok-label="Si"
									        data-btn-cancel-label="No"
									        data-title="¿Estás seguro de que deseas eliminar la votación?"
											>
								    		<i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
								    	</a>
								    </li>
								    @endif
							    @endif

							    <li role="separator" class="divider"></li>
							    <li class="dropdown-header">Acción participativa:</li>
							    <li>
							  		<a href="{{route('action.edit', $action->id)}}">
							  			<i class="fa fa-edit" aria-hidden="true"></i> Editar
							  		</a>
							  	</li>

							    @if(Gate::allows('admin'))
							    	<li role="separator" class="divider"></li>
								    <li>
								    	<form role="form" method="POST" action="{{ route('action.delete')}}">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input type="hidden" name="action_id" value="{{ $action->id }}">
											<input type="hidden" name="_method" value="DELETE">
											<button type="submit" class="btn btn-danger btn-block rect"
											data-toggle="confirmation"
											data-popout="true"
											data-placement="bottom"
											data-btn-ok-label="Si"
									        data-btn-cancel-label="No"
									        data-title="¿Estás seguro de que deseas eliminarla?"
											>
											  <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar acción participativa
											</button>
										</form>
								    </li>
							    @endif
							  </ul>
							</div>
						@endif
					</div>
				</div>
				<br>	
				@include('partials/warning')
				<ul class="nav nav-tabs">
	  				<li class="active"><a href="#">Descripción</a></li>
	  				@if(count($proposals)>0)
	  					<li><a href="#" class="scroll-link" data-id="propuestas">Propuestas</a></li>
	  				@endif
	  				@if(!is_null($action->poll) )
	  					<li><a href="#" class="scroll-link" data-id="votacion">Votación</a></li>
	  				@endif
	  				@if(count($action->works()) > 0 )
	  					<li><a href="#" class="scroll-link" data-id="obras">Obras</a></li>
	  				@endif
	  			</ul>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include('partials/success')
	  		<p>{{$action->description}}</p>
	  		@if($action->howto)
	  			<h3>¿Cómo participo?</h3>
	  			<p>{{$action->howto}}</p>
	  		@endif

	  		@if(count($action->newvents())>0)
	  			<hr>
	  			@include('partials/newvents_list')
	  		@endif
	  		
	  		<hr>
	  		<strong>COMPARTIR</strong>
	  		<div class="ssk-group">
			    <a href="" class="ssk ssk-facebook"></a>
			    <a href="" class="ssk ssk-twitter"></a>
			    <a href="" class="ssk ssk-google-plus"></a>
			    <a href="" class="ssk ssk-pinterest"></a>
			    <a href="" class="ssk ssk-tumblr"></a>
			</div>
			<br>
		</div>
	</div>
</div>

@if(count($action->proposals) > 0 )
<div class="jumbotron no-margin-bottom page-section" id="propuestas">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2 class="light">
					Propuestas <a href="#" class="scroll-top back-to-top btn btn-modern pull-right"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>
				</h2>
				<br />
				@include('partials/proposals_list')
			</div>
		</div>
	</div>
</div>
@endif


@if(!is_null($action->poll) )
	<div class="jumbotron jumbo-img no-margin-bottom page-section" id="votacion">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-10 col-md-offset-1">
					<h1 class="light" align="center" style="color: #f5f5f5;">
						<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
						VOTACIÓN
						<a href="#" class="scroll-top back-to-top btn btn-modern modern-light pull-right"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>
					</h1>
					<br />
					@include('partials/poll')
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($action->works()) > 0 )
	<div class="jumbotron no-margin-bottom page-section" id="obras">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h2 class="light">
						Obras del municipio <a href="#" class="scroll-top back-to-top btn btn-modern pull-right"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>
					</h2>
					<br />
					@include('partials/works_list')
				</div>
			</div>
		</div>
	</div>
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