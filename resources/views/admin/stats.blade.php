@extends('layout')

@section('styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('content')

<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2"> 
				<h2>
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					Administración de la plataforma
				</h2>
				@include('partials/success')
				@include('partials/errors')
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"> 
			<div class="row">
				<div class="row">
					<div class="col-md-6">
						<h4>
							<span aria-hidden="true"></span>
							Estadisticas
						</h4>
						<br>
						<ul>
                            @foreach ($locations as $location)
                            <li>Ubicacione: <strong>{{$location['country']}}</strong></li>
                            <li>Usuarios: <strong>{{$location['total']}}</strong></li>
                            @endforeach
							@foreach ($visitors_pages as $visitor_pages)
                            <li>Visitas en el dia: <strong>{{$visitor_pages['visitors']}}</strong></li>
                            @endforeach

                            @foreach ($sessionDuration as $session)
                            <li>Tiempo en la aplicacion: <strong>{{Carbon\CarbonInterval::seconds($session['time'])->cascade()->forHumans()}}</strong></li>
                            @endforeach
                            
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
