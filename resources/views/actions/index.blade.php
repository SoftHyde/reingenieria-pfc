@extends('layout')

@section('content')
<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2>Acciones participativas</h2>
				@include('partials/success')
				@include('partials/actions_list')
			</div>
		</div>
	</div>
</div>



@endsection