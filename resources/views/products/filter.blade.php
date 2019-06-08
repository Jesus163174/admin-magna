<div class="row">	
	<div class="col-md-6">
		<label for="">Buscar producto por categoria</label>
		<select class="form-control" name="categoria" id="">
			<option selected="" onclick="allCategories();" value="0">Todas las categorias</option>
			@foreach($categories as $category)
				<option onclick="SearchByCategories({{$category->id}});" value="{{$category->id}}">{{$category->nombre}}</option>
			@endforeach
		</select>
	</div>
	@if(Auth::user()->rol == 'administrador')
		<div class="col-md-6">
			<label for="">Buscar productos por sucursal</label>
			<select class="form-control" name="bussine" id="">
				<option selected="" onclick="allBussines();" value="0">Todas las sucursales</option>
				@foreach($bussines as $bussine)
					<option onclick="searchByBussines({{$bussine->id}});" value="{{$bussine->id}}">{{$bussine->nombre}}</option>
				@endforeach
			</select>
		</div>
	@endif
	<div class="col-md-12" style="margin-top: 8px;">
		<div class="alert alert-success">
			<span>{{count($products)}} Producto(s) encontrados</span>
		</div>
	</div>
</div>