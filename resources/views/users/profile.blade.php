@extends('layouts.dashboard.dashboard')
@section('title',Auth::user()->name)
@section('content')
<div class="row">
	<div class="col-lg-4 col-md-5">
		<div class="card card-user">
			<div class="image">
				
			</div>
			<div class="content">
				<div class="author">
					<img class="avatar border-white" src="{{asset('assets/img/user.svg')}}" alt="..."/>
					<h4 class="title">{{$user->name}}<br />
						<a href="#"><small>{{$user->rol}}</small></a>
					</h4>
				</div>
				<p class="description text-center">
					Bodega
				</p>
				<p class="description text-center">
					<span class="label label-success">{{$user->status}}</span>
				</p>
			</div>
			<hr>
			
		</div>
		
	</div>
	<div class="col-lg-8 col-md-7">
		<div class="card">
			<div class="header">
				<h4 class="title">Editar datos</h4>
			</div>
			<div class="content">
				<form action="{{asset('dashboard/v/admin/usuarios/'.$user->id)}}" method="post">
					@csrf
					{{method_field('put')}}  
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label>Nombre</label>
								<input type="text" required="" class="form-control border-input" name="name"  value="{{$user->name}}">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Celular</label>
								<input type="text" required="" class="form-control border-input" name="celular" value="{{$user->celular}}">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Email</label>
								<input type="email" required="" class="form-control border-input" name="email" value="{{$user->email}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Sucursal</label>
								<select name="bussine_id" required="" class="form-control" id="">
									<option value="{{$user->bussine_id}}">Bodega</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Rol</label>
								<select name="rol" required="" class="form-control"  id="">
									<option value="{{$user->rol}}">{{$user->rol}}</option>
									<option value="administrador">Administrador</option>
									<option value="vendedor">Vendedor</option>
								</select>
							</div>
						</div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-info btn-fill btn-wd">Actualizar Credenciales</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>


</div>
@stop