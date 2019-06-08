@extends('layouts.dashboard.dashboard')
@section('title','Agregar categoria')
@section('content')
<div class="col-md-12">
	<a href="{{asset('dashboard/v/admin/categorias/')}}" class="float">
		<i class="fa fa-undo  my-float"></i>
	</a>
	<div class="card">
		<div class="header">
			<h4 class="title">Agrega una nuevoa categoria al sistema</h4>
		</div> <hr>
		<div class="content content-form table-responsive table-full-width">
			<form action="{{asset('dashboard/v/admin/categorias')}}" method="post">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<label for="">Nombre </label>
						<input type="text" required  class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" placeholder="Ingresa el nombre de la categoria" value="{{ old('name') }}">
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