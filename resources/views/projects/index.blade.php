@extends('layout')

@section('content')
<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2>Proyectos</h2>
				@include('partials/projects_list')
			</div>
		</div>
	</div>
</div>



@endsection