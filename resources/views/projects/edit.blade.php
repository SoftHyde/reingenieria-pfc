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
				<h2>Editar<br><small><a href="{{route('project', $project->id)}}">({{$project->name}})</a></small></h2>
			</div>
		</div>
	</div>
</div>

<div class="container fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">	
			@include('partials/errors')
			<form role="form" method="POST" enctype="multipart/form-data" action="{{ route('project.update', $project->id) }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PUT">

				<div class="form-group">
					<label class="control-label">Título</label>
					<input type="text" name="name" class="form-control" value="{{ $project->name }}" required>
				</div>
				<br>
				<div class="form-group">
					<label class="control-label">Descripción</label>
					<textarea class="form-control" rows="3" name="description" required>{{$project->description}}</textarea>
				</div>
				<table class="table table-bordered" id="dynamicAddRemove2">
                    <tr>
                        <th>Moderador mail</th>
                        <th>Opcion</th>
                    </tr>
                    @foreach ($project->moderator as $moderator)
                        <tr>
                            <td><input id="admin_email" type="text" name="moderator_email[{{$loop->index}}][moderator_email]"  class="form-control" value="{{ $moderator->user->email }}" required/>
                            </td>
                            @if($loop->first)
                            <td><button type="button" name="add" id="dynamic-ar2" class="btn btn-outline-primary">Agregar email</button></td>
                            @else
                            <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
				<br>
                <table class="table table-bordered" id="dynamicAddRemove">
                    <tr>
                        <th>Tag</th>
                        <th>Opcion</th>
                    </tr>
                    
                    @foreach ($project->projectTag as $ptag)
                        <tr>
                            <td><input id="tags" type="text" name="tag[{{$loop->index}}][tag]"  class="form-control" value="{{ $ptag->tag->name }}" required/>
                            </td>
                            @if($loop->first)
                            <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Agregar Tag</button></td>
                            @else
                            <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                            @endif
                        </tr>
                        
                    @endforeach
                </table>
                <br>
                <div class="form-group">
					<label class="control-label">Fecha Limite</label>
					<input id="limit_date" type="date" name="limit_date" value="{{$project->limit_date }}" class="form-control" required>
				</div>
                <br>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg" style="margin-right: 15px;">
						Guardar Cambios
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
<script type="text/javascript">
	$(document).ready(function () {
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
    var table = document.getElementById("dynamicAddRemove");
    var i = table.rows.length-2;
    console.log(i);
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input  id="tags" type="text" name="tag[' + i +
            '][tag]" placeholder="Enter tag" class="form-control" required /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
<script type="text/javascript">
    var table = document.getElementById("dynamicAddRemove2");
    var j = table.rows.length-2;
    console.log(j);
    $("#dynamic-ar2").click(function () {
        ++j;
        $("#dynamicAddRemove2").append('<tr><td><input id="admin_email" type="text" name="moderator_email[' + j +
            '][moderator_email]" placeholder="Agregar Email" class="form-control" required/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endsection