@extends('layouts.dashboard.dashboard')
@section('title','Ventas')
@section('content')

<div class="col-md-12">
	<div class="card">
		<div class="header">
			<h4 class="title">Buscar ventas entre fechas.</h4>
			
		</div>
		<div class="content">
			<div class="row">
				<div class="col-md-7">
					<div class="row">
						<form action="{{asset('dashboard/v/admin/filtro')}}" style="margin-top: -8px;" method="get">
							<div class="col-md-4">
								<input type="date" required name="date_start" class="form-control" style="background-color: #ffff; border:solid 1px #66615B; color:#333;">
							</div>
							<div class="col-md-4">
								<input type="date" required name="date_end" class="form-control" style="background-color: #ffff; border:solid 1px #66615B; color:#333;">
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-success">Filtrar entre fechas</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="header">
			<h4 class="title">
				Listado de las ventas pagadas
				@if(isset($reporte_fechas))
					del dia {{$fecha1}} al {{$fecha2}}
				@endif
			</h4>
			<p class="category">Ventas pagadas.</p>
		</div>
		<div class="content table-responsive ">
			{{--@if(isset($reporte_fechas))
				<a href="{{asset('dashboard/v/admin/reporte/ventas_por_fecha?inicio='.$fecha1.'&final='.$fecha2)}}" class="btn btn-success">Descargar reporte de fechas</a>
			@endif--}}
			<table id="data" class="table table-striped table-bordered">
				<thead>
					<th class="text-center">FOLIO</th>
					<th class="text-center">Total</th>
					<th class="text-center">Vendedor</th>
					<th class="text-center">Sucursal</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Estatus</th>
				</thead>
				<tbody>
					@foreach($sales as $sale)
						<tr>
							<td class="text-center">
								<a href="{{asset(Auth::user()->rol.'/ventas/'.$sale->ventaID)}}">{{$sale->ventaID}}</a>
							</td>
							<td class="text-center">${{number_format($sale->total)}}</td>
							<td class="text-center">
								{{$sale->vendedor}}
							</td>
							<td class="text-center">
								{{$sale->bussine}}
							</td>
							<td class="text-center">{{$sale->date}}</td>
							<td class="text-center">
								<span class="label {{$sale->status}}">{{$sale->status}}</span>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
			<div class="content">
				
			</div>
		</div>
	</div>
</div>
@stop