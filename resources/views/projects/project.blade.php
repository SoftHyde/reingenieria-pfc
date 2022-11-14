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