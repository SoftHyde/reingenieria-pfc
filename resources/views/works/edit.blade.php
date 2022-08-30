@extends('layout')

@section('content')

<section class="gray">
	<div class="jumbotron">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-8 col-md-offset-2">
					<h2>Editar <a href="{{route('works', $work->id)}}">{{$work->title}}</a> </h2>

					Publicado en <a href="{{route('action', $work->action_id)}}">{{$work->action->title}}</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-8 col-md-offset-2">
				<form role="form" method="POST" action="{{route('work.update', $work->id)}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" name="location" id="location" value="{{$work->location}}">

					<div class="form-group">
						<label class="control-label">Título</label>
						<input type="text" name="title" class="form-control" value="{{ $work->title }}" required>
					</div>

					<div class="form-group">
						<label class="control-label">Contenido</label>
						<textarea id="summernote" class="form-control" rows="8" name="content" required>{{$work->content}}</textarea>
					</div>

					<div class="form-group">
						<label class="control-label">Ubicación</label>
						<div class="input-group">
						    <input class="form-control width100" type="text" name="address" class="form-control" value="{{ $work->location }}" id="address">
						    <span class="input-group-btn">
						        <button class="btn btn-primary" type="button" onclick="markAddress()" >
						        	Localizar en el mapa
						        </button>
						    </span>
						</div>
						<br>
						<div id="map"></div>
					</div>

					<div class="form-group">
						<hr>
						<button type="submit" class="btn btn-primary btn-lg" style="margin-right: 15px;">
							Enviar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDLZblL7GuHX4hcogyC28dfFLS4V9Zzow8"></script>
<script src="/js/gmaps.js"></script>
<script>
	var map = new GMaps({
	  el: '#map',
	  lat: -31.637890,
      lng: -60.692774
	});
	map.setZoom(13);
	if($('#address').val() ){
		markAddress();
		map.setZoom(15);
	}

	function markAddress(){
		map.removeMarkers();

		GMaps.geocode({
		  address: $('#address').val(),
		  callback: function(results, status) {
		    if (status == 'OK') {
		      var latlng = results[0].geometry.location;
		      map.setCenter(latlng.lat(), latlng.lng());
		      var marker = map.addMarker({
		        lat: latlng.lat(),
		        lng: latlng.lng()
		      });
		      var infowindow = new google.maps.InfoWindow;
		      infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);

              $('#location').val(results[0].formatted_address);
		    }
		  }
		});

		map.setZoom(15);
	}
  	
</script>
@endsection