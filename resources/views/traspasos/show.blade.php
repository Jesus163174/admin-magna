@extends('layouts.dashboard.dashboard')
@section('content')
	<div class="col-md-8">
		@if(Auth::user()->bussine_id == $traspaso->envia and $traspaso->estatus == 'enviado')
			<div class="alert alert-success">Esperando a que la sucursal {{$suc_recibe->nombre}} reciba los productos</div>
		@endif
		<div class="card">
			<div class="content">
				Sucursal Envia: {{$suc_envia->nombre}} - Usuario que envia: {{$usuario->name}}<hr>
				Sucursal Recibe: {{$suc_recibe->nombre}} <hr>
				Fecha: {{$traspaso->created_at->diffForHumans()}}
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="header">
				<h3 class="title text-center">Traspaso {{$traspaso->estatus}}</h3>
			</div> <hr>
			<div class="content text-center">
				@if(Auth::user()->bussine_id == $traspaso->recibe and $traspaso->estatus == 'enviado')
					<form action="{{asset('dashboard/aceptar/traspaso/'.$traspaso->id)}}" method="post"  class="text-center">
						@csrf
						{{method_field('put')}}
						<button type="submit" class="btn btn-success">Aceptar traspaso de productos</button>
					</form>
				@endif

				@if(Auth::user()->rol == 'administrador' and $traspaso->estatus == 'aceptado')
					<form action="{{asset('dashboard/v/admin/autorizar/traspaso/'.$traspaso->id)}}" method="post" class="text-center">
						@csrf
						{{method_field('put')}}
						<button type="submit" class="btn btn-danger">Autorizar Traspaso</button>
					</form>
				@endif

				<form action="{{asset('regresar_traspaso')}}"  method="post">
					@csrf
					<input type="hidden" value="{{$traspaso->id}}" name="traspaso_id">
					<button type="submit" class="btn btn-success">Devolucion de productos</button>
				</form>

			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Detalle de traspaso</h4> 
				<a href="{{asset('dashboard/v/admin/reporte/traspaso/'.$traspaso->id)}}" class="btn btn-xs btn-info">Imprimir hoja  de reporte</a> ({{count($products_traspasos)}}) Productos en el traspaso
			</div><hr>
			<div class="content">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<th class="text-center">Producto</th>
							<th class="text-center">Cantidad</th>
							<th class="text-center">Costo</th>
							<th class="text-center">Venta</th>
							<th class="text-center">Clave producto</th>
							<th class="text-center">Codigo</th>
							<th class="text-center">Codigo unidad</th>
						</thead>
						<tbody>
							@foreach($products_traspasos as $product)
								<tr>
									<td class="text-center">{{$product->producto}}</td>
									<td class="text-center">{{$product->cantidad}}</td>
									<td class="text-center">${{$product->costo}}</td>
									<td class="text-center">${{$product->precio_Venta}}</td>
									<td class="text-center">{{$product->clave_producto}}</td>
									<td class="text-center">{{$product->codigo}}</td>
									<td class="text-center">{{$product->clave_unidad}}</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop