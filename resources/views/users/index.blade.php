@extends('layouts.dashboard.dashboard')
@section('title','Empleados')
@section('content')
<div class="col-md-12">
	
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	<div class="card">
		<div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
			<h4 class="title">Listado de usuario activos.</h4>
			<p class="category">
				<a class="btn btn-success btn-sm" href="{{asset(Auth::user()->rol.'/usuarios/create')}}">
					Agregar usuario
				</a>
			</p>
		</div>
		<div class="content table-responsive">
			<table id="data" class="table table-striped">
				<thead>
					<th class="text-center">ID</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Email</th>
					<th class="text-center">Estatus</th>
					<th class="text-center">Sucursal</th>
					<th class="text-center">Rol</th>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td class="text-center">{{$user->id}}</td>
							<td class="text-center">
								<a href="{{asset(Auth::user()->rol.'/perfil?id='.$user->id)}}">{{$user->name}}</a>
							</td>
							<td class="text-center">{{$user->email}}</td>
							<td class="text-center">
								<span class="label label-success">
									{{$user->status}}
								</span>
							</td>
							<td class="text-center">{{$user->bussine}}</td>
							<td class="text-center">{{$user->rol}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			
		</div>
	</div>
</div>
@stop