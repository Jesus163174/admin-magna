<table class="table table-striped">
	<thead>
		<th class="text-center">ID</th>
		<th class="text-center">Sucursal envia</th>
		<th class="text-center">Sucursla Recibe</th>
		<th class="text-center">Usuario envia</th>
		<th class="text-center">Fecha</th>
		<th class="text-center">Estatus</th>
	</thead>
	<tbody>
		@foreach($traspasos as $traspaso)
			<tr>
				<td class="text-center">
					@if($traspaso->estatus == 'enviado')
						<a href="{{asset('dashboard/v/admin/traspasos/'.$traspaso->id)}}">{{$traspaso->id}}</a>
					@elseif($traspaso->estatus == 'proceso' and $traspaso->envia == Auth::user()->bussine_id)
						<a href="{{asset('dashboard/seleccionar-productos/'.$traspaso->id)}}">{{$traspaso->id}}</a>
					@else
						<a href="{{asset('dashboard/v/admin/traspasos/'.$traspaso->id)}}">{{$traspaso->id}}</a>
					@endif
				</td>
				<td class="text-center">{{$traspaso->suc_envia}}</td>
				<td class="text-center">{{$traspaso->suc_recibe}}</td>
				<td class="text-center">{{$traspaso->usuario}}</td>
				<td class="text-center">{{$traspaso->fecha}}</td>
				<td class="text-center">{{$traspaso->estatus}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="content">
	{{$traspasos->links()}}
</div>