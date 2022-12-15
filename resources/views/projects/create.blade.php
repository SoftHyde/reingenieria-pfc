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
				<h2>Nuevo Proyecto de Ley</h2>
			</div>
		</div>
	</div>
</div>

<div class="container fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">	
			@include('partials/errors')
            <form role="form" method="POST" enctype="multipart/form-data" action="{{ route('project.store') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label class="control-label">Nombre</label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
				</div>
				<br>
				<div class="form-group">
					<label class="control-label">Descripción</label>
					<textarea class="form-control" rows="3" name="description" required>{{old('description')}}</textarea>
				</div>
				<br>
				<table class="table table-bordered" id="dynamicAddRemove2">
                    <tr>
                        <th>Moderador mail</th>
                        <th>Opcion</th>
                    
                    <tr>
                        <td><input id="admin_email" type="text" name="moderator_email[0][moderator_email]" placeholder="Ingrese el mail del moderador" class="form-control" value="{{ old('project_tag') }}" required/>
                        </td>
                        <td><button type="button" name="add" id="dynamic-ar2" class="btn btn-outline-primary">Agregar email</button></td>
                    </tr>
                </table>
				<br>
                <table class="table table-bordered" id="dynamicAddRemove">
                    <tr id="top-Tag">
                        <th>Tag</th>
                        <th>Opcion</th>
                    </tr>
                    <tr>
                        <td><input id="tags" type="text" name="tag[0][tag]" placeholder="Ingrese el tag" class="form-control" value="{{ old('project_tag') }}"required/>
                        </td>
                        <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Agregar Tag</button></td>
                    </tr>
                </table>
                {{-- <div class="form-group">
					<label class="control-label">Tag</label>
					<input id="project_tag" name="project_tag" value="{{ old('project_tag') }}" class="form-control" placeholder="Empieza a escribir para filtrar resultados..." required>
				</div> --}}
				<br>
                <div class="form-group">
					<label class="control-label">Fecha Limite</label>
					<input id="limit_date" type="date" name="limit_date" value="{{ old('limit_date') }}" class="form-control" placeholder="Fecha limite de participacion" required>
				</div>
                <br>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg" style="margin-right: 15px;">
						Crear Proyecto de Ley
					</button>
				</div>
			</form>
			<hr>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" defer></script>
<script type="text/javascript">
$(document).ready(function load1() {
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
<script type="text/javascript">
	$(document).ready(function load() {
	var options = {
	  	url: "/info-tags",
	    getValue: "name",
	    list: {
	        match: {
	            enabled: true
	        }
	    },
	};
	$("#tags").easyAutocomplete(options);
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input id="tags" type="text" name="tag[' + i +
            '][tag]" placeholder="Enter tag" class="form-control" value="' + document.getElementsByName("tag[0][tag]")[0].value + '" required /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
		document.getElementsByName("tag[0][tag]")[0].value = "";
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
	
</script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar2").click(function () {
        ++i;
        $("#dynamicAddRemove2").append('<tr><td><input id="admin_email" type="text" name="moderator_email[' + i +
            '][moderator_email]" placeholder="Agregar Email" class="form-control" value="' + document.getElementsByName("moderator_email[0][moderator_email]")[0].value + '" required/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
		document.getElementsByName("moderator_email[0][moderator_email]")[0].value="";
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
	
</script>
@endsection