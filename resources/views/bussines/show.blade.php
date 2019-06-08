@extends('layouts.dashboard.dashboard')
@section('title',$bussine->nombre)
@section('content')
	<div class="col-md-4">
		<div class="card">
			<div class="header text-center">
				<h4 class="title">Inventario de la sucursal</h4>
			</div><hr>
			<div class="content text-center">
				<img src="https://image.flaticon.com/icons/svg/1069/1069102.svg" alt="">
			</div>
			<div class="content">
				<a href="{{asset(Auth::user()->rol.'/sucursales/'.$bussine->id.'/productos')}}" class="btn btn-info btn-sm form-control">Ver inventario</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="header text-center">
				<h4 class="title">Ventas de la sucursal</h4>
			</div><hr>
			<div class="content text-center">
				<img src="https://image.flaticon.com/icons/svg/1055/1055659.svg" alt="">
			</div>
			<div class="content">
				<a href="{{asset(Auth::user()->rol.'/sucursales/'.$bussine->id.'/productos')}}" class="btn btn-info btn-sm form-control">Ver inventario</a>
			</div>
		</div>
	</div>
@stop