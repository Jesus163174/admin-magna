@extends('layouts.dashboard.dashboard')
@section('title','Agrega nuevo traspaso')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Detalle de traspaso</h4>  <hr style="margin-bottom:4px !important;">
			</div>
			<div class="content" style="margin:0px;"> 
				Sucursal que recibe: {{$traspaso->suc_recibe}} <hr style="margin-bottom:4px !important; margin-top:4px !important;">
				Fecha: {{$traspaso->fecha}} <hr style="margin-bottom:4px !important; margin-top:4px !important;">
				Usuario: {{$traspaso->usuario}}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="header">
				<h4 class="title">Selecciona los productos que vas a traspasar</h4>
			</div>
			<div class="content table-responsive table-full-width">
				<div class="row">
					<div class="col-md-10 col-lg-10 col-sm-12">
						<form action="{{asset('dashboard/traspaso/buscar/producto/')}}" method="get">
							
							<input style="margin: 10px;" placeholder="Buscar Producto" type="search" class="form-control" name="filtro">
							<input type="hidden" value="{{$traspaso->id}}" name="traspaso">
						</form>
						
					</div>
				</div>
				<hr>
				<div class="content table-responsive table-full-width">
					<table class="table table-striped">
						<thead>
							<th class="text-center">ID</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Costo</th>
							<th class="text-center">Venta</th>
							<th class="text-center">Cantidad</th>
							<th class="text-center">Acciones</th>
						</thead>
						<tbody>
							@foreach($products as $product)
							<form action="{{asset('dashboard/agregar-producto-traspaso')}}" method="post">
								@csrf
								<input type="hidden" value="{{$product->id}}" name="producto_id">
								<input type="hidden" value="{{$traspaso->id}}" name="traspaso_id">
								<tr>
									<td class="text-center">{{$product->id}}</td>
									<td class="text-center">{{$product->producto}} - {{$product->stock}}</td>
									<td class="text-center">${{$product->costo}}</td>
									<td class="text-center">${{$product->venta}}</td>
									<td class="text-center">
										<input class="form-control" type="number" required="" max="{{$product->stock}}" name="cantidad" placeholder="Cantidad a traspasar">
									</td>
									<td class="text-center">
										<button type="submit" class="btn btn-success">Agregar</button>
									</td>
								</tr>
							</form>
							
							@endforeach
						</tbody>
					</table>
					<div class="content">
						{{$products->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="header">
				<h4 class="title">Productos a traspasar</h4>
			</div>
			<div class="content">
				@if(count($products_traspasos) != 0)
					<form action="{{asset('dashboard/traspaso/terminar')}}" method="post" class="text-center">
						@csrf
						<input type="hidden" value="{{$traspaso->id}}" name="traspaso_id">
						<button type="submit" class="btn btn-success ">Terminar Traspaso</button>
					</form> <hr>
				@else
					<h4 class="titel text-center">Sin productos agregados</h4>
				@endif
				<div class="row">
					<div class="col-sm-12">
						@foreach($products_traspasos as $product)
							<ul class="list-group">
								<li class="list-group-item">{{$product->producto}} - 
									<span class="label label-success">
										{{$product->cantidad}} a traspasar
									</span>
								</li>
							</ul>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
{{--<div class="content table-responsive table-full-width">
					<table class="table table-striped">
						<thead>
							<th class="text-center">ID</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Costo</th>
							<th class="text-center">Venta</th>
							<th class="text-center">Cantidad</th>
							<th class="text-center">Acciones</th>
						</thead>
						<tbody>
							@foreach($products as $product)
							<tr>
								<td class="text-center">{{$product->id}}</td>
								<td class="text-center">{{$product->producto}}</td>
								<td class="text-center">${{$product->costo}}</td>
								<td class="text-center">${{$product->venta}}</td>
								<td class="text-center">
									<input class="form-control" name="cantidad" placeholder="Cantidad a traspasar">
								</td>
								<td class="text-center">
									<button class="btn btn-success">Agregar</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="content">

					</div>
				</div> --}}