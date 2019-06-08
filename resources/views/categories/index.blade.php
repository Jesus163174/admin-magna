@extends('layouts.dashboard.dashboard')
@section('title','Categorias')
@section('content')
	
<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	<div class="card">
		<div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
			<h4 class="title">Listado de todas las categorias</h4>
			<p class="category">
				<a class="btn btn-success btn-sm" href="{{asset(Auth::user()->rol.'/categorias/create')}}" >
					Agregar nueva categoria
				</a>
			</p>
		</div>
		<div class="content table-responsive ">
			<table id="data" class="table table-striped table-bordered">
				<thead>
					<th class="text-center">ID</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Acciones</th>
				</thead>
				<tbody>
					@foreach($categories as $category)
						<tr>
							<td class="text-center">{{$category->id}}</td>
							<td class="text-center">
								<a href="{{asset('dashboard/v/admin/categorias/'.$category->id.'/edit')}}">
									{{$category->nombre}}
								</a>
							</td>
						
							<td class="text-center">
								<a href="{{asset('dashboard/v/admin/categorias/'.$category->id)}}">Ver productos</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			
		</div>
	</div>
</div>
@stop