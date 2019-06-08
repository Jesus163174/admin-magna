@extends('layouts.dashboard.dashboard')
@section('title','Traspasos')
@section('content')
<div class="col-md-12">
	<a href="{{asset('dashboard/seleccionar-sucursal')}}" class="float">
		<i class="fa fa-plus my-float"></i>
	</a>
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
    <div class="card">
		<div class="header">
			<h4 class="title">Listado de todos los traspasos.</h4>
		</div>
		<div class="content table-responsive table-full-width">
			@include('traspasos.data')
		</div>
	</div>
</div>
@stop