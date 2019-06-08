@extends('layouts.dashboard.dashboard')
@section('title','Agregar sucursal')
@section('content')
<div class="col-md-12">
	
	<div class="card">
		<div class="header">
			<h4 class="title">Agrega una nueva sucursal al sistema</h4>
		</div> <hr>
		<div class="content content-form table-responsive table-full-width">
			<form action="{{asset('dashboard/v/admin/sucursales/')}}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<label for="">Nombre de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" placeholder="Ingresa el nombre de la sucursal" value="{{ old('name') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Calle</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="calle" placeholder="Ingresa la calle de la sucursal" value="{{ old('calle') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Colonia de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="colonia" placeholder="Ingresa la colonia de la sucursal" value="{{ old('name') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Estado de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="estado" placeholder="Ingresa el estado de la sucursal" value="{{ old('calle') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Ciudad de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="ciudad" placeholder="Ingresa la ciudad de la sucursal" value="{{ old('name') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Pais de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="pais" placeholder="Ingresa el Pais de la sucursal" value="{{ old('calle') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Numero exterior de la sucursal</label>
						<input type="number" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="exterior" placeholder="Ingresa el numero exterior de la sucursal" value="{{ old('name') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Numero Interior de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="interior" placeholder="Ingresa el estado de la sucursal" value="0">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Caja inicial de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="caja" placeholder="Ingresa la caja inicial de la sucursal" value="">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Porcentaje de P/tarjeta de la sucursal</label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="tarjeta" placeholder="Ingresa el porcentaje con P/tarjeta
						 de la sucursal" value="{{ old('calle') }}">
						@if ($errors->has('nombre'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('nombre') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="row">
					<div class="form-group">
						<button type="submit" class="btn btn-success margin-top margen-izquierda">Agregar Categoria</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop