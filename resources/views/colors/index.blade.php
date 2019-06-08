@extends('layouts.dashboard.dashboard')
@section('title','Colores')
@section('content')

<div class="col-md-12">
    @if (session('status_success'))
        <div class="alert alert-success">
            {!! session('status_success') !!}
        </div>
    @endif
    <div class="card">
        <div class="header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
            <h4 class="title">Listado de colores</h4>
            <p class="category">
				<a class="btn btn-success btn-sm" href="{{asset(Auth::user()->rol.'/colores/create')}}" >
					Agregar Color
				</a>
			</p>
        </div>
        <div class="content">
            <table id="data" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Color</th>
                        <th>IMEI</th>
                        <th>Marca</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($colors as $color)
                        <tr>
                            <td>
                                <a href="{{asset('administrador/colores/'.$color->id.'/edit')}}">{{$color->color}}</a>
                            </td>
                            <td>
                                {{$color->imei}}
                            </td>
                            <td>
                                {{$color->marca->nombre}}
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop