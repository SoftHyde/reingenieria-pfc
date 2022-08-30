@extends('layout')

@section('styles')
<link rel="stylesheet" href="/css/bootstrap-datepicker3.css"/>
@endsection

@section('content')
<div class="jumbotron no-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h2>
					{{ $action->title }}
					<br>
					<span class="light text-muted">Crear votación</span>
				</h2>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3" id="form-container">
			@include('partials/errors')

			<form class="form" role="form" method="POST" action="{{ route('create-poll') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="action_id" value="{{ $action->id }}">

				<div class="form-group">
					<label class="control-label">Pregunta *</label>
					<input type="text" name="question" class="form-control" value="{{ old('question') }}" required>
				</div>

				<div class="form-group">
					<label class="control-label">
						Opciones *
						<br>
						<span class="light text-muted">(Selecciona las propuestas que participarán de la votación. Mínimo: 2)</span>
					</label>
				    @foreach($proposals as $proposal)
					    <div class="checkbox">
						  <label><input type="checkbox" name="{{$proposal->id}}">
						  	{{$proposal->title}}
						  </label>
						</div>
					@endforeach
				</div>

				<div class="form-group">
					<label class="control-label">Fecha de cierre *</label>
					<input class="form-control" id="date" name="date" placeholder="dd-mm-aaaa" type="text" value="{{ old('date') }}" required>
				</div>

				<br>
				<span class="text-muted">* = Requerido</span>
				<br>

				<hr>

				<div class="form-group" align="center">
					<button type="submit" class="btn btn-default" style="margin-right: 15px;">
						Publicar votación
					</button>
				</div>
			</form>		
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]');
      var options={
        format: 'dd-mm-yyyy',
        container: $('#form-container'),
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
@endsection