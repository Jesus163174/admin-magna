@extends('layouts.dashboard.dashboard')
@section('title','Listado de productos por categoria')
@section('content')
<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	 <div class="card">
    	<div class="content">
    		@include('products.filter')
    	</div>
    </div>
	<div class="card">
		<div class="header">
			<h4 class="title">Listado de productos de la categoria <a href="#">{{$category->nombre}}</a>.</h4>
			<p class="category">Listado de todos los productos activos.</p>
		</div>
		<div class="content table-responsive">
			@include('products.data')
		</div>
	</div>
</div>
@stop
@section('js')
	<script>
		function SearchByCategories($category_id){
			let server = "http://localhost:8000/dashboard/v/admin/";
			let route  = server+"producto?categoria="+$category_id;
			location.href= route;
		}
		function allCategories(){
			let server = "http://localhost:8000/dashboard/v/admin/";
			let route  = "productos";
			location.href= route;
		}
		function allBussines(){
			let server = "http://localhost:8000/dashboard/v/admin/";
			let route  = "productos";
			location.href= route;
		}
		function searchByBussines($bussine_id){
			let server = "http://localhost:8000/dashboard/v/admin/";
			let route  = server+"producto_?sucursal="+$bussine_id;
			location.href= route;
		}
	</script>
@stop