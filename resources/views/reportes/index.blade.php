@extends('layouts.dashboard.dashboard')
@section('title','Reportes')
@section('content')
<div class="col-md-12 text-center">
	
</div> <br>
<div class="row">
	<form action="{{asset('reportes/inventario')}}" method="post">
		@csrf
		<div class="col-md-4">
			<div class="card">
				<div class="header" style="display:flex; align-items:center; justify-content:space-between;">
					<img src="https://image.flaticon.com/icons/svg/1055/1055644.svg" style="width: 40px; height: 40px; border-radius: 50%;" alt="">
					<p class="title">Reporte de inventario</p>
				</div>
				<div class="content">
					<label for="">Selecciona una sucursal</label>
					<select name="sucursal_id" class="form-control" id="">
						<option value="0">Inventario general</option>
						@foreach($sucursales as $sucursal)
						<option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
						@endforeach
					</select>
				</div>
				<div class="content">
					<button type="submit" class="btn btn-success form-control">Generar reporte</button>
				</div>
			</div>
		</div> 
	</form>
	<form action="{{asset('dashboard/v/admin/reporte/ventas_por_fecha')}}" method="get">
		@csrf
		<div class="col-md-4">
			<div class="card">
				<div class="header" style="display:flex; align-items:center; justify-content:space-between;">
					<img src="https://image.flaticon.com/icons/svg/1055/1055644.svg" style="width: 40px; height: 40px; border-radius: 50%;" alt="">
					<p class="title">Reporte de ventas entre fechas</p>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-6">
							<label for="">Fecha Inicial</label>
							<input type="date" name="inicio" class="form-control">
						</div>
						<div class="col-md-6">
							<label for="">Fecha Final</label>
							<input type="date" name="final" class="form-control">
						</div>
					</div>
				</div>
				<div class="content">
					<button type="submit" class="btn btn-success form-control">Generar reporte</button>
				</div>
			</div>
		</div> 
	</form>
	<div class="col-md-4">
		<div class="card">
			<div class="header text-center" style="display:flex; justify-content:space-between;">
				<img src="https://image.flaticon.com/icons/svg/1055/1055644.svg" style="width: 40px; height: 40px; border-radius: 50%;" alt="">
				<p class="title">Reporte de ventas del dia</p>
			</div>
			<div class="content">
				<br>
				<br>
				<br>
			</div>
			<div class="content">
				<a href="{{asset('dashboard/v/admin/reporte/ventas_del_dia')}}" class="btn btn-success form-control">Generar reporte</a>
			</div>

		</div>
	</div> 
</div>



@stop