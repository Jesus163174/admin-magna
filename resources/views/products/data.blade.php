<table  id="data" class="table table-striped table-bordered">
	<thead>
		<th class="text-center">Nombre</th>
		<th class="text-center">Codigo</th>
		<th class="text-center">Marca</th>
		<th class="text-center">Color</th>
		<th class="text-center">Stock</th>
		<th class="text-center">Costo</th>
		<th class="text-center">Venta</th>
		<th class="text-center">Categoria</th>
		<th class="text-center">Sucursal</th>
	</thead>
	<tbody>
		@foreach($products as $product)
			<tr>
				<td class="text-center">
					@if(Auth::user()->rol == 'administrador')
						<a href="{{asset(Auth::user()->rol.'/productos/'.$product->id.'/edit')}}">{{$product->nombre}}</a>
					@else
						{{$product->nombre}}
					@endif
				</td>
				<td class="text-center">{{$product->codigo}}</td>
				<td class="text-center">{{$product->marca->nombre}}</td>
				<td class="text-center">{{$product->color->color}}</td>
				<td class="text-center">
					@if($product->existencia >5)
					<span class="label label-success">{{$product->existencia}}</span>
					@else
					<span class="label label-danger">{{$product->existencia}}<span>
					@endif
				</td>
				<td class="text-center">${{number_format($product->costo,2,'.',',')}}</td>
				<td class="text-center">${{number_format($product->precio_Venta,2,'.',',')}}</td>
				<td class="text-center">{{$product->category->nombre}}</td>
				<td class="text-center">{{$product->bussine->nombre}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="content">
	
</div>