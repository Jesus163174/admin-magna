@extends('layouts.dashboard.dashboard')
@section('content')
	<div class="card">
		<div class="header">
			<h4 class="title">Selecciona la sucursal a traspasar</h4> <hr>
		</div>
		<div class="content">
			<div class="row">
				@foreach($bussines as $bussine)
					<form action="{{asset('dashboard/v/admin/traspasos')}}" method="post">
						@csrf
						<input type="hidden" name="bussine_id" value="{{$bussine->id}}">
						<div class="col-md-8" style="margin-left: 25px;">
							<ul class="list-group" style="display: flex; align-items: center; justify-content: space-between;">
								<li class="list-group-item" style="width: 70%;">{{$bussine->nombre}}</li>
								<button type="submit" class="btn btn-success btn-sm">Seleccionar</button>
							</ul>
							<hr>
						</div>
					</form>
				@endforeach
				{{$bussines->links()}}
			</div>
		</div>
	</div>
@stop