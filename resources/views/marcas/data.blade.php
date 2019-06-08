<table  id="data" class="table table-striped table-bordered">
	<thead>
		<th class="text-center">Nombre</th>
		<th class="text-center">Estatus</th>
	</thead>
	<tbody>
		@foreach($brands as $brand)
			<tr>
				<td class="text-center">
                    <a href="{{asset(Auth::user()->rol.'/marcas/'.$brand->id.'/edit')}}">
                        {{$brand->nombre}}
                    </a>
                </td>
				<td class="text-center">
                    @if($brand->estatus == 0)
                        <span class="label label-success">Activo</span>  
                    @endif
                </td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="content">
	
</div>