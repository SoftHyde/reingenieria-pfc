@extends('layout')

@section('styles')
<!-- easy-autocomplete -->
<link rel="stylesheet" type="text/css" href="/bower_components/EasyAutocomplete/dist/easy-autocomplete.min.css">
@endsection

@section('content')

<div class="jumbotron">
	<div class="container fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2>Editar<br><small><a href="{{route('action', $action->id)}}">({{$action->title}})</a></small></h2>
			</div>
		</div>
	</div>
</div>

<div class="container fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">	
			@include('partials/errors')

			<form role="form" method="POST" enctype="multipart/form-data" action="{{ route('action.update', $action->id) }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PUT">

				<div class="form-group">
					<label class="control-label">Título</label>
					<input type="text" name="title" class="form-control" value="{{ $action->title }}" required>
				</div>
				<br>
				<div class="form-group">
					<label class="control-label">Descripción</label>
					<textarea id="summernote" class="form-control" rows="3" name="description" required>{{$action->description}}</textarea>
				</div>
				<div class="form-group">
					<label class="control-label">¿Cómo participo?</label>
					<textarea class="form-control" rows="3" name="howto" placeholder="Describe cómo debe interactuar el ciudadano con esta acción participativa..." required>{{$action->howto}}</textarea>
				</div>
				<br>
				<div class="form-group">
					<label class="control-label">Administrador (email)</label>
					<input id="admin_email" type="email" name="admin_email" value="{{ $action->admin->email }}" class="form-control" placeholder="Empieza a escribir para filtrar resultados..." required>
				</div>
				<br>
				<label class="control-label">Funcionalidades</label>
				<div class="form-group alert alert-success">
				    <div id="create-proposals">
				    	<label>¿Habilitar publicación de propuestas?</label>
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="allow_proposals" value="1" id="yes-proposals" @if($action->allow_proposals) checked @endif >Si</label>
					    	<label class="radio-inline"><input type="radio" name="allow_proposals" value="0" id="no-proposals" @if(!$action->allow_proposals) checked @endif >No</label>
					    </div>
					</div>
					<div id="proposal-options" class="proposal-options @if(!$action->allow_proposals) hidden @endif">
						<hr>
				    	<label>¿Quién puede crear propuestas?</label>
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="proposal_posters" value="admin" @if($action->proposal_posters == 'admin') checked @endif>Sólo el administrador</label>
					    	<label class="radio-inline"><input type="radio" name="proposal_posters" value="general" @if($action->proposal_posters == 'general') checked @endif>Administrador y ciudadanos</label>
					    </div>
					    <hr>
				    	<label>¿Habilitar comentarios en propuestas?</label>
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="allow_comments" value="1" @if($action->allow_comments) checked @endif>Si</label>
					    	<label class="radio-inline"><input type="radio" name="allow_comments" value="0" @if(!$action->allow_comments) checked @endif>No</label>
					    </div>
					    <hr>
				    	<label>¿Habilitar creación de votaciones entre propuestas?</label> (Deben ser creadas por el administrador)
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="allow_polls" value="1" @if($action->allow_polls) checked @endif>Si</label>
					    	<label class="radio-inline"><input type="radio" name="allow_polls" value="0" @if(!$action->allow_polls) checked @endif>No</label>
					    </div>
					</div>
					<hr>
					<div id="works">
				    	<label>¿Habilitar publicación de obras del municipio?</label>
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="allow_works" value="1" @if($action->allow_works) checked @endif>Si</label>
					    	<label class="radio-inline"><input type="radio" name="allow_works" value="0" @if(!$action->allow_works) checked @endif>No</label>
					    </div>
					</div>
					<hr>
					<div id="newvents">
				    	<label>¿Habilitar publicación de noticias y eventos?</label>
				    	<div class="radio">
					    	<label class="radio-inline"><input type="radio" name="allow_newvents" value="1" @if($action->allow_newvents) checked @endif>Si</label>
					    	<label class="radio-inline"><input type="radio" name="allow_newvents" value="0" @if(!$action->allow_newvents) checked @endif>No</label>
					    </div>
					</div>
				</div>
				<div class="form-group">
			    	<label for="avatar">Logo</label>
			    	<div class="alert alert-info">
			    		<div class="row">
				    		<div class="col-md-9 bottom-column">	
			    				<strong>Subir un archivo</strong>
			    				<br>
			    				<p>(La imagen debe ser cuadrada para su correcta visualización)</p>
			    				<input type="file" name="avatar">
				    		</div>

				    		<div class="col-md-3">
				    			<img class="img-fluid img-rounded img-small" src="{{$action->avatar}}" alt="Logo">		
				    		</div>
				    	</div>
			    	</div>
			  	</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-lg" style="margin-right: 15px;">
						Guardar
					</button>
				</div>
			</form>
			<hr>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="/bower_components/EasyAutocomplete/dist/jquery.easy-autocomplete.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {

	var options = {
	  	url: "/info-usuarios",
	    getValue: "email",
	    template: {
	        type: "description",
	        fields: {
	            description: "name"
	        }
	    },
	    list: {
	        match: {
	            enabled: true
	        }
	    },
	};
	$("#admin_email").easyAutocomplete(options);

	$('#no-proposals').change(function(e, value){
	    $('#proposal-options').addClass('hidden');
	  });
	$('#yes-proposals').change(function(e, value){
	    $('#proposal-options').removeClass('hidden');
	  });
});
</script>
@endsection