@extends('layouts.dashboard.dashboard')
@section('title','Vender')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="row">
			<div class="col-lg-12 col-sm-12">
				@if (session('stock_none'))
			        <div class="alert alert-danger">
			            {!! session('stock_none') !!}
			        </div>
			    @endif
				<div class="card" style="border:1px solid rgba(0,0,0,.4) !important;">
					<div class="content">
						<div class="row">
							<div class="col-xs-12">
								<form action="{{asset('dashboard/orden/agregar/producto')}}"  method="post">
									@csrf
									<div class="numbers">
										<p style="margin-bottom: 3px; font-size: 17px; font-weight: 1.3em;" class="text-left">Agregar por código</p>
										<input type="text" name="code" required="" value=""  class="form-control" autofocus placeholder="Código de barras">
									</div>
								</form>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<a data-toggle="modal" class="btn btn-info" data-target=".bs-example-modal-lg" style="cursor: pointer;">
									<i class="fa fa-cog" class="btn btn-primary" ></i> Consultar Inventario
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="card" style="border:1px solid rgba(0,0,0,.4) !important;">
					<div class="header">
						<h4 class="title">Productos de la venta</h4> <hr style="margin-bottom: 3px;">
					</div>
					<div class="content table-responsive table-full-width">
						<table class="table table-striped">
							<thead>
								<th class="text-center">Producto</th>
								<th class="text-center">Precio</th>
								<th class="text-center">Cantidad</th>
								<th class="text-center">Subtotal</th>
								<th class="text-center">Accion</th>
							</thead>
							<tbody>
								@foreach($productos as $producto)
								<tr>
									<td class="text-center">{{$producto->producto}}</td>
									<td class="text-center">${{number_format($producto->price,2,'.',',')}}</td>
									<td class="text-center">
										<input type="text" name="cantidad" value="{{$producto->amount}}" class="form-control">
									</td>
									<td class="text-center">${{number_format($producto->subtotal,2,'.',',')}}</td>
									<form action="{{asset('dashboard/orden/productos_orden/delete/')}}" method="post">
										@csrf
										<input type="hidden" required="" name="producto_id" value="{{$producto->id}}">
										<td class="text-center">
											<button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
										</td>
									</form>


								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="content">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<form action="{{asset('dashboard/venta/')}}" method="post">
		<div class="card" style="border:1px solid rgba(0,0,0,.4) !important;">
			<div class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="icon-big icon-success text-center">
							<p style="color:#243882; font-weight:900; font-size:17px;">Detalle de la venta</p> <hr>
							<select name="cliente_id" required id="" class="form-control">
								<option  value="" selected>Selecciona un cliente</option>
								@foreach($detail['clients'] as $client)
									<option value="{{$client->id}}">{{$client->nombre}} {{$client->apellido}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="content">
							<div class="row">
								<div class="col-md-6">
									<span>Subtotal: </span>
								</div>
								<div class="col-md-6 text-right">${{number_format($detail['subtotal'],2,'.',',')}}</div>
							</div><hr>
							<div class="row">
								<div class="col-md-6">
									<span>Descuento: </span>
								</div>
								<div class="col-md-6 text-right">${{number_format($detail['cashDiscount'],2,'.',',')}}</div>
							</div><hr>
							<div class="row">
								<div class="col-md-6">
									<span>P/Tarjeta: </span>
								</div>
								<div class="col-md-6 text-right">${{number_format($detail['pay'],2,'.',',')}}</div>
							</div><hr>
							<div class="row">
								<div class="col-md-6">
									<span class="total strong-sale">Total: </span>
								</div>
								<div class="col-md-6 text-right total-number strong-sale">${{number_format($detail['total'],2,'.',',')}}</div>
							</div>
						</div>
						<div class="">
							<hr />
							<div class="">
								@if($detail['total']!= 0) 
								
									@csrf
									<button class="btn btn-success btn-sm form-control" style="width: 100% !important;"><i class="ti-calendar"></i> Terminar Venta</button>
								
								@endif
							</div>
						</div> 
					</div>
					
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
@stop
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@stop