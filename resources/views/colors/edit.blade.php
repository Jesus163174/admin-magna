@extends('layouts.dashboard.dashboard')
@section('title','Colores')
@section('content')
<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Crear nuevas marcas</h4>
			</div>
			<div class="content">
				<form action="{{asset('administrador/marcas')}}" method="post">
					@csrf
					<div class="form-group">
						<label for="">Nombre de la marca</label>
						<input type="text"  class="form-control" name="nombre" placeholder="">
					</div>

					<button class="btn btn-success btn-sm">Agregar</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Editar color</h4>
			</div>
			<div class="content">
				<form action="{{asset('administrador/colores/'.$color->id)}}" method="post">
					@csrf
					{{method_field('put')}}
					@include('colors.form',['btn'=>'Acutalizar'])
				</form>
			</div>
		</div>
	</div>
@stop