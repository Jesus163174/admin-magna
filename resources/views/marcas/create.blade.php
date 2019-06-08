@extends('layouts.dashboard.dashboard')
@section('title','Marcas')
@section('content')
<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
	<div class="card">
		<div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
			<h4 class="title">
                @if($operacion == 0)
                    Agregar una nueva marca
                @else
                    Actualizar marca
                @endif
            </h4>
		</div>
		<div class="content">
            <form action="{{asset(Auth::user()->rol.'/'.$url)}}" method="post">
                @csrf 
                @if($operacion == 1)
                    {{method_field('put')}}
                @endif
                <div class="form-group">
                    <label for="">Nombre completo</label>
                    <input type="text" value="{{$brand->nombre}}" class="form-control" name="nombre" placeholder="">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        @if($operacion == 0)
                            Agregar nueva marca
                        @else
                            Actualizar marca
                        @endif
                    </button>
                </div>
            </form>
        </div>
	</div>
</div>
@stop  