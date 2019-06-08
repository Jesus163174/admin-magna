@extends('layouts.dashboard.dashboard')
@section('title','Inicio')
@section('content')
<div class="row">
	<div class="col-lg-3 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-warning text-center">
							<i class="ti-user"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>Usuarios</p>
							{{$users}}
						</div>
					</div>
				</div>
				<a href="{{asset(Auth::user()->rol.'/usuarios/create')}}" class="btn btn-success">Agregar trabajador</a>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-success text-center">
							<i class="ti-wallet"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>Productos</p>
							{{$products}}
						</div>
					</div>
				</div>
				<a href="{{asset(Auth::user()->rol.'/productos/create')}}" class="btn btn-success">Agregar producto</a>

			</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-danger text-center">
							<i class="ti-pulse"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>Categorias</p>
							{{$categories}}
						</div>
					</div>
				</div>
				<a href="{{asset(Auth::user()->rol.'/categorias/create')}}" class="btn btn-success">Agregar categoria</a>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-info text-center">
							<i class="fa fa-home"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>Sucursales</p>
							{{$bussines}}
						</div>
					</div>
				</div>
				<a href="{{asset(Auth::user()->rol.'/sucursales/create')}}" class="btn btn-success">Agregar sucursal</a>
			</div>
		</div>
	</div>
</div>
<div class="row">

	<div class="col-md-4">
		<div class="card" id="descargar_grafica_ventas">
			<div class="header">
				<h4 class="title">Grafica de las ventas del dia</h4>
			</div>
			<div class="content">
				<canvas id="myChart" width="400" height="400"></canvas>
			</div><hr>
			<div class="content">
				<a download="ventasdeldia.png" id="print"  class="btn btn-success">Descargar grafica</a>
			</div>
		</div>
	</div>
</div>


@stop

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script>
		$('#print').on('click',function(){
 			var url_base64jp = document.getElementById("myChart").toDataURL("image/png");
            $('#print').attr('href',url_base64jp)
		});
	</script>
	<script>
		var densityCanvas = document.getElementById("myChart");
		var oilData = {
		    labels: [
		       @foreach($grafica as $dato)
		  			"{{$dato->sucursal}}(${{$dato->total}})",
		  		@endforeach
		    ],
		    datasets: [
		        {
		            data: [
			            @foreach($grafica as $dato)
			  				{{$dato->total}},
			  			@endforeach
		            ],
		            backgroundColor: [
		                "#7AC29A",
		                "#EB5E28",
		                "#84FF63",
		                "#8463FF",
		                "#6384FF"
		            ]
		    	}
		    ]
		};

	var pieChart = new Chart(densityCanvas, {
	  type: 'pie',
	  data: oilData
	});
	</script>
@stop