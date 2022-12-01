@extends('layout')

@section('content')
<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2>{{ $action->title }}</h2>
				<div class="panel panel-default">
					<div class="panel-heading">Publicar obra del municipio</div>
					<div class="panel-body">
						@include('partials/errors')

						<form class="form-horizontal" role="form" method="POST" action="{{ route('work.post-create') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="action_id" value="{{ $action->id }}">
							<input type="hidden" name="location" id="location">

							<div class="form-group">
								<label class="col-md-2 control-label">Título</label>
								<div class="col-md-10">
								    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label">Contenido</label>
								<div class="col-md-10">
									<textarea  class="form-control" rows="8" name="content" required>{{old('content')}}</textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label">Ubicación</label>
								<div class="col-md-10">
									<div class="input-group">
									    <input class="form-control width100" type="text" name="address" class="form-control" value="{{ old('address') }}" id="address">
									    <span class="input-group-btn">
									        <button class="btn btn-primary" type="button" onclick="markAddress()" >
									        	Localizar en el mapa
									        </button>
									    </span>
									</div>
									<br>
									<div id="map"></div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-10 col-md-offset-2">
									<hr>
									<button type="submit" class="btn btn-primary btn-lg" style="margin-right: 15px;">
										Publicar
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>
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