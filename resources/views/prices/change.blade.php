@extends('layouts.dashboard.dashboard')
@section('title','Precios')
@section('content')
<div class="col-md-12">
	@if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif

    <div class="card">
        <div class="header">
            <h4 class="title">Seleccionar un producto</h4>
        </div>
        <div class="content">
            <form action="{{asset(Auth::user()->rol.'/cambiar_precio')}}" method="post">
                @csrf
                <input type="hidden" value="{{$product->id}}" name="productID">
                <div class="form-group">
                    <label for="">Ingresa un nuevo precio</label>
                    <input type="number" required step="any" class="form-control" name="price">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Cambiar Precio</button>
            </form>

            <hr>
            <h3>Detalle del producto</h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>Nombre: </strong>{{$product->nombre}}</li>
                <li class="list-group-item"><strong>Costo: </strong>${{number_format($product->costo,2,'.',',')}}</li>
                <li class="list-group-item"><strong>Precio actual: </strong>${{number_format($product->precio_Venta,2,'.',',')}}</li>
                <li class="list-group-item"><strong>Marca: </strong>{{$product->marca->nombre}}</li>
                <li class="list-group-item"><strong>Color: </strong>{{$product->color->color}}</li>
                <li class="list-group-item"><strong>Extencia: </strong>{{$product->existencia}}</li>
                <li class="list-group-item"><strong>Categoria: </strong>{{$product->category->nombre}}</li>
                <li class="list-group-item"><strong>Codigo: </strong>{{$product->codigo}}</li>
            </ul>

            <hr>

            <h3>Historial de cambios de  precio({{count($prices)}})</h3>
            @foreach($prices as $price)
                <ul class="list-group">
                    <li class="list-group-item"><strong>Fecha: </strong>{{$price->date}}</li>
                    <li class="list-group-item"><strong>Usuario: </strong>{{$price->user->name}}</li>
                    <li class="list-group-item"><strong>Precio anterior: </strong>${{number_format($price->price,2,'.',',')}}</li>
                </ul> <hr>
            @endforeach
        </div>
    </div>
</div>
@stop