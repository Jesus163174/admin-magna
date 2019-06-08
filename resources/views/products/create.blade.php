@extends('layouts.dashboard.dashboard')
@section('title','Listado de usuarios')
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="header">
			<h4 class="title">Buscar marca y color por codigo de color</h4>
		</div> <hr>
		<div class="content ">
			<form action="{{asset(Auth::user()->rol.'/productos/create')}}"  method="get">
				<div class="form-group">
					<label for="imei">IMEI</label>
					<input type="text" required value="{{$imei}}" class="form-control" name="imei" placeholder="Ingresa el Codigo de color">
				</div>
				<button class="btn btn-success btn-sm" type="submit">Buscar</button>
			</form>
		</div>
	<div>
	<div class="card">
		<div class="header">
			<h4 class="title">Agrega un nuevo producto al sistema</h4>
		</div> <hr>
		<div class="content content-form table-responsive table-full-width">
			<form action="{{asset('dashboard/v/admin/productos')}}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<label for="">Nombre del producto</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" placeholder="Ingresa el nombre del producto" value="{{ old('nombre') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Codigo de barras</label>
						<input type="text" required class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" placeholder="Ingresa el codigo de barras">
						@if ($errors->has('codigo'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('codigo') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Existencia en bodega</label>
						<input type="number" value="1" min="1" required class="form-control {{ $errors->has('existencia') ? ' is-invalid' : '' }}" name="existencia" placeholder="Ingresa la existencia del producto en inventario">
						@if ($errors->has('existencia'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('existencia') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Costo del producto.</label>
						<input type="number" step="any" min="1" required class="form-control {{ $errors->has('costo') ? ' is-invalid' : '' }}" name="costo" placeholder="Ingresa el costo del producto">
						@if ($errors->has('costo'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('costo') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Precio de venta del producto</label>
						<input type="number" min="1" required class="form-control {{ $errors->has('precio_Venta') ? ' is-invalid' : '' }}"  name="precio_Venta" placeholder="Ingresa el  precio de venta del producto.">
						@if ($errors->has('precio_Venta'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('precio_Venta') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Sucursal</label>
						<select name="bussine_id" required  class="form-control {{ $errors->has('bussine_id') ? ' is-invalid' : '' }}"  >
							<option value="" selected="">Selecciona la sucursal del producto</option>
							@foreach($bussines as $bussine)
								<option value="{{$bussine->id}}">{{$bussine->nombre}}</option>
							@endforeach
						</select>
						@if ($errors->has('bussine_id'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('bussine_id') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="">Categoria del producto</label>
						<select name="category_id"  required class="form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }}"  id="">
							<option value="" selected="">Selecciona la categoria del producto</option>
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->nombre}}</option>
							@endforeach
						</select>
						@if ($errors->has('category_id'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('category_id') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Marca</label>
							@if($color==null)
								<div class="alert alert-warning">
									<span>Debes de seleccionar un color</span>
								</div>
							@else
								<select name="marca_id" class="form-control" id="">
									<option value="{{$color->marca->id}}">{{$color->marca->nombre}}</option>
								</select>
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							
							@if($color==null)
								<label for="">Color</label>
								<div class="alert alert-warning">
									<span>Debes de seleccionar un color</span>
								</div>
							@else
								<label for="">Color</label>
								<select name="color_id" class="form-control" id="">
									<option value="{{$color->id}}">{{$color->color}}</option>
								</select>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">IVA del producto</label>
						<input type="number" step="any" min="1" required class="form-control {{ $errors->has('iva') ? ' is-invalid' : '' }}" name="iva" placeholder="Ingresa el  IVA del producto.">
						@if ($errors->has('iva'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('iva') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Clave de unidad del producto</label>
						<input type="text"  class="form-control {{ $errors->has('clave_unidad') ? ' is-invalid' : '' }}" name="clave_unidad" placeholder="Ingresa la clave de unidad del producto.">
						@if ($errors->has('clave_unidad'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('clave_unidad') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="">Clave del producto</label>
						<input type="text"  required class="form-control {{ $errors->has('clave_producto') ? ' is-invalid' : '' }}" name="clave_producto" placeholder="Ingresa la clave  del producto.">
						@if ($errors->has('clave_producto'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('clave_producto') }}</strong>
							</span>
						@endif
					</div>
				</div>
				@if($imei != '')
				<div class="row">
					<div class="form-group">
						<button type="submit" class="btn btn-success margin-top margen-izquierda">Agregar Producto</button>
					</div>
				</div>
				@endif
			</form>
		</div>
	</div>
</div>
@stop
@section('js')
	
@stop