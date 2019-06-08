@extends('layouts.dashboard.dashboard')
@section('title','Sucursales')
@section('content')

<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	<div class="card">
		<div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
			<h4 class="title">Listado de sucursales.</h4>
			<p class="category">
				<a class="btn btn-success btn-sm" href="{{asset(Auth::user()->rol.'/sucursales/create')}}" >
					Agregar sucursal
				</a>
			</p>
		</div>
		<div class="content table-responsive ">
			<table id="data" class="table table-striped">
				<thead>
				
					<th class="text-center">Nombre</th>
					<th class="text-center">Caja Inicial</th>
					
					<th class="text-center">Tarjeta</th>
					<th class="text-center">Estatus</th>
				</thead>
				<tbody>
					@foreach($bussines as $bussine)
						<tr>
							
							<td class="text-center">
								<a href="{{asset(Auth::user()->rol.'/sucursales/'.$bussine->id.'/edit')}}">{{$bussine->nombre}}</a>
							</td>
							<td class="text-center">${{$bussine->caja}}</td>
							
							<td class="text-center">{{$bussine->tarjeta}}%</td>
							<td class="text-center">
								<span class="label label-success">
									{{$bussine->estatus}}
								</span>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop