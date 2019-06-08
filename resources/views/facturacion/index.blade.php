@extends('layouts.dashboard.dashboard')
@section('title','Ventas')
@section('content')
<div class="col-md-12">
    <div class="card">
		<div class="header">
			<h4 class="title">
				Factura del día
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
					@foreach($ventas as $sale)
						<tr>
							<td class="text-center">
								<a href="{{asset('dashboard/v/admin/ventas/'.$sale->ventaID)}}">{{$sale->ventaID}}</a>
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