@extends('layouts.dashboard.dashboard')
@section('title','Listado de usuarios')
@section('content')
<div class="col-md-12">
	<a href="{{asset('dashboard/v/admin/usuarios/')}}" class="float">
		<i class="fa fa-undo  my-float"></i>
	</a>
	<div class="card">
		<div class="header">
			<h4 class="title">Agrega un nuevo usuario al sistema</h4>
		</div> <hr>
		<div class="content content-form table-responsive table-full-width">
			<form action="{{asset('dashboard/v/admin/usuarios')}}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<label for="">Nombre completo</label>
						<input type="text" required  class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="name" placeholder="Ingresa el nombre completo del usuario" value="{{ old('name') }}">
						@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<label for="">Celular</label>
						<input type="text" required class="form-control" name="celular" placeholder="Ingresa el celular del usuario">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Email</label>
						<input type="email" required class="form-control" name="email" placeholder="Ingresa el email del usuario">
					</div>
					<div class="col-md-6">
						<label for="">Password</label>
						<input type="password" required class="form-control" name="password" placeholder="Ingresa la contraseña del usuario">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="">Rol</label>
						<select name="rol" required class="form-control" name="rol" id="">
							<option value="" selected="">Selecciona el rol del usuario</option>
							<option value="administrador">Administrador</option>
							<option value="vendedor">Vendedor</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="">Sucursal</label>
						<select name="bussine_id" required class="form-control" name="rol" id="">
							<option value="" selected="">Selecciona la sucursal del usuario</option>
							@foreach($bussines as $bussine)
							<option value="{{$bussine->id}}">{{$bussine->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="">Comision de usuario por ventas</label>
						<input type="number" required class="form-control"  name="comision" step="any"  placeholder="Ingresa el email del usuario">
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<button type="submit" class="btn btn-success margin-top margen-izquierda">Agregar Usuario</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop