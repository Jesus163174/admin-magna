let server = "http://www.ital2201.com/";
let route  = "dashboard/buscar/inventario?filtro=";

let input_buscar_producto = $('#input_buscar_producto');
let datos_inventario      = $('#datos_inventario');

$(input_buscar_producto).keyup(function(ev){
	var keycode = (ev.keyCode ? ev.keyCode : ev.which);
	if(keycode == '13'){
	    ev.preventDefault();
	    if(this.search != '')
	    	consultar_inventario();
	} 
});

function consultar_inventario(){
	let valor_filtro = input_buscar_producto.val();
	let endpoint = server+route+valor_filtro;
	$.ajax({
		async: true,
		type: "GET",
		dataType: "json",
		contentType: false,
        processData: false,
        url:endpoint,
        headers: { 
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-Type':'Application/json',
        	'Accept':'Application/json',
        	'Access-Control-Allow-Headers': '*',
        	'Access-Control-Allow-Headers': 'x-requested-with',
        	'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE'
        },
        success:function(data){
        	mostrar_datos(data);
        }
	});
}
function mostrar_datos(data){
	let html;
	$(datos_inventario).empty();
	console.log(html)
	data.forEach((item) => {
		html = `
		<tr>
			<td style="font-size:"10px !important;">${item.producto}</td>
			<td>${item.venta}</td>
			<td>${item.codigo}</td>
			<td>${item.stock}</td>
			<td>
				<form id="form_envio-${item.id}">
					<input type="text" class="form-control" name="cant" value="0" id="cant-${item.id}" placeholder="Cantidad" />
				</form>	
			</td>
			<td>
				<button class="btn btn-danger btn-xs" onclick="agregar_venta(${item.id});">Agregar</button>
			</td>
		</tr>`;
		datos_inventario.append(html);
	});
}
function agregar_venta(producto_id){
	let endpoint = server+'dashboard/orden/agregar/producto';
	let form = $('#form_envio-'+producto_id);
	let data = form.serialize();
	console.log(data);
	let cantidad = $('#cant-'+producto_id).val();
	formData = new FormData();
	formData.append('producto_id',producto_id);
	formData.append('cantidad',cantidad);
	$.ajax({
		async: true,
        type: "POST",
        dataType: "json",
        cache: false,
        //contentType: "application/x-www-form-urlencoded",
        contentType: false,
        processData: false,
        url: endpoint,
        data: data,
        headers: { 
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-Type':'Application/json',
        	'Accept':'Application/json',
        	'Access-Control-Allow-Headers': '*',
        	'Access-Control-Allow-Headers': 'x-requested-with',
        	'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE'
        },
	});
}