@extends('layout')

<!-- Description -->
<meta name="description" content="{{$work->title}}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="{{$work->title}}">
<meta itemprop="image" content="http://pfc.local/images/works.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="{{$work->title}}">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/works.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/works.jpg" />
<meta property="og:description" content="{{$work->title}}" />

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
			@include('partials/errors')
			@include('partials/success')
		  	<h2>
				<a href="{{ route('action', ['id' => $work->action->id]) }}"><small>{{$work->action->title}}</small> </a> <small> >> Obra del municipio</small>

				@if(Gate::allows('admin_action', $work->action->admin_id))
					<div class="dropdown pull-right">
					  <button class="btn btn-modern dropdown-toggle btn-lg" type="button" data-toggle="dropdown">
					  	<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li>
					    	<a href="{{route('work.edit', $work->id)}}"><i class="fa fa-edit" aria-hidden="true"></i> Editar obra</a>
					    </li>
					    <li role="separator" class="divider"></li>
					    <li>
					    	<form role="form" method="POST" action="{{ route('work.delete')}}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="work_id" value="{{ $work->id }}">
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" class="btn btn-danger btn-block rect"
								data-toggle="confirmation"
								data-popout="true"
								data-placement="bottom"
								data-btn-ok-label="Si"
						        data-btn-cancel-label="No"
						        data-title="¿Estás seguro de que deseas eliminarla?"
								>
								<i class="fa fa-ban" aria-hidden="true"></i> Eliminar obra
								</button>
							</form>
					    </li>
					  </ul>
					</div>
				@endif

				<br>
				{{ $work->title }}
			</h2>
			<p class="proposal-text">{!! nl2br($work->content) !!}</p>
			<br>
      @if($work->location)
        <h3>Ubicación</h3>
        <p id="location">{{$work->location}}</p>
    		<div id="map"></div>
      @endif
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
			@if(count($work->ratings) === 0)
				<span class="text-muted">Sin calificaciones aún</span>
			@else
				<div class="row">
					<div class="col-md-4" align="center">
						<!-- Calificaciones -->
						<h2>
							{{round(array_sum($work->ratings->lists('stars')->toArray())/count($work->ratings),2)}}/5
						</h2>
					</div>
					<div class="col-md-4" align="center">
						<h2>
							@for($i=0; $i < round(array_sum($work->ratings->lists('stars')->toArray())/count($work->ratings)); $i++)
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
							@endfor

							@for($i= round(array_sum($work->ratings->lists('stars')->toArray())/count($work->ratings)); $i< 5; $i++)
								<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
							@endfor
						</h2>
					</div>
					<div class="col-md-4" align="center">
						<h2 class="text-muted light">
							<small>
							Calificaciones: {{count($work->ratings)}}
							</small>
						</h2>
					</div>
				</div>
			@endif
			@include('partials/warning')
		</div>
	</div>
</div>
<br>


<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if(count($work->ratings) > 0)
					<h3>Calificaciones</h3>
					@include('partials/ratings_list')
				@endif
			  	@if(!Auth::check())
			  		<p class="text-muted" align="center">Inicia sesión para calificar</p>
			  	@elseif(Gate::allows('rate', $work->id))
				  	<div class="panel">
				  		<div class="panel-heading">
				  			Calificar
				  		</div>
						<form class="form-horizontal" role="form" method="POST" action="/calificar">
							<div class="panel-body">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="work_id" value="{{ $work->id }}">
								<input type="hidden" name="n_stars" id="n_stars" value="0">

								<div class="form-group">
									<label class="col-md-2 control-label">Estrellas</label>
							        <div class="col-md-10 lead">
								        <span id="stars" class="starrr"></span>
								        (<span id="count">0</span>)
							        </div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Comentario</label>
									<div class="col-md-10">
										<textarea class="form-control" rows="5" name="comment" required>{{old('comment')}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col col-md-10 col-md-offset-2">
										<button type="submit" class="btn btn-modern btn-lg" style="margin-right: 15px;">
										Enviar
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				@else
					<p class="text-muted" align="center">Ya calificaste esta obra</p>
				@endif
			</div>
		</div>
	</div>
</div>	
@endsection


@section('scripts')
<script src="/js/stars.js"></script>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyDLZblL7GuHX4hcogyC28dfFLS4V9Zzow8"></script>
<script src="/js/gmaps.js"></script>
<script>

  GMaps.geocode({
    address: $('#location').text(),
    callback: function(results, status) {
      if (status == 'OK') {
        var latlng = results[0].geometry.location;
        var map = new GMaps({
          el: '#map',
          lat: latlng.lat(),
          lng: latlng.lng()
        });
        map.setZoom(16);
        var marker = map.addMarker({
          lat: latlng.lat(),
          lng: latlng.lng()
        });
        var infowindow = new google.maps.InfoWindow;
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
      }
    }
  });

</script>
@endsection