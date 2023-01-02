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
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
					Estadisticas
				</h2>
				@include('partials/success')
				@include('partials/errors')
			</div>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-block">
        <div class="row" align="center" style="margin-top: 10px">
            <div class="col-md-12">
                @foreach ($totalUsers as $totalUser)
                <h3 class="card-title" style="color: black; margin-top:10px">Usuarios Totales: <strong>{{$totalUser['total']}}</strong></h3>
                @endforeach
            </div>
        </div>
       
    </div>
</div>
<div class="row" style="display: flex; justify-content: center;">
    <div class="col-md-6" id="GraficoAcciones" >
        <div class="row">
            Usuarios por mes:
            <div id="myfirstchart" style="height: 250px;"></div>
        </div>
        <div class="row" >
            <div class="col-md-3 col-md-offset-2" align="right">
                Meses:
            </div>
               <div class="col-md-3" align="left">
                  <select class="form-control" id="months_select_action">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option selected="selected">12</option>
                  </select>
               </div>
        </div>
    </div>
</div>
<div class="row" style="display: flex; justify-content: center;">
    <div class="col-md-6">
        Retencion de usuarios:
        <div id="mysecondchart" style="height: 230px;"></div>
    </div>
</div>

@section('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script type="text/javascript">

// Grafico de progresion mensual
var months_actions = Morris.Area({
  element: 'myfirstchart',
  data: [
    { y: '2022-01', usuarios: 0}
  ],
  xkey: 'y',
  ykeys: ["users"],
  labels: ['Usuarios'],
});


// Muestro datos de acuerdo la cantidad de meses
$("#months_select_action")
  .change(function () {
    var n = $( "#months_select_action option:selected" ).text();
    $.ajax({
      type: "GET",
      dataType: 'json',
      url: "/info-usuarios/" + n
    })
    .done(function( data ) {
		months_actions.setData(data);
    })
    .fail(function() {
      alert( "error occured" );
    });
  })
  .change();

// Grafico de usuarios por distrito
var districts = Morris.Donut({
  element: 'mysecondchart',
  data: [{label: 'Santa Fe', value: 100}],
 formatter: function (y, data) { return y }
});
$.ajax({
      type: "GET",
      dataType: 'json',
      url: "/info-tipos-usuarios"
    })
    .done(function( data ) {
      districts.setData(data);
    })
    .fail(function() {
      alert( "error occured" );
    });

</script>
@endsection