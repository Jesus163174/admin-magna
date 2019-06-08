@extends('layouts.dashboard.dashboard')
@section('title','Inventario')
@section('content')
<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	
	<div class="card">
		<div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
			<h4 class="title">Listado de productos.</h4>
			<p class="category">
				@if(Auth::user()->rol == 'administrador')
					<a class="btn btn-success btn-sm" href="{{asset(Auth::user()->rol.'/productos/create')}}">Agregar producto</a>
				@endif
			</p>
		</div>
		<div class="content table-responsive ">
			@include('products.data')
		</div>
	</div>
</div>

@stop
