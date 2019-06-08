<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','DashBoardController@index')->middleware('auth','userRol');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix'=>'dashboard/v/admin'],function(){
	Route::get('/','DashBoardController@index')->middleware('userRol');
	Route::resource('/usuarios','UsuariosController');
	Route::get('/perfil/{id?}','UsuariosController@profile');
	Route::get('usuario/{buscar?}','UsuariosController@search');
	Route::resource('/sucursales','BussinesController')->middleware('userRol');
	Route::resource('/productos','ProductsController');
	
	Route::get('/producto_/{sucursal?}','ProductsController@searchByBussine');
	Route::get('/producto_buscar/{filtro?}','ProductsController@searchLIKE');

	Route::resource('categorias','CategoriasController');
	Route::resource('/ventas','SalesController');
	Route::get('buscar/{filtro_venta?}','SalesController@search');
	Route::get('filtro/{date_start?}/{date_end?}','SalesController@FilterBetweenDates');
	
	Route::group(['prefix'=>'reporte'],function(){
		Route::get('ventas_del_dia','SalesController@reporte_venta_dia');
		Route::get('ventas','SalesController@reporte_ventas');
		Route::get ('ventas_por_fecha/{inicio?}/{final?}','SalesController@reporte_fechas');
	});

	Route::resource('traspasos','TraspasosController');
	Route::get('reporte/traspaso/{traspaso_id}','TraspasosController@reporte_traspaso');
	Route::put('autorizar/traspaso/{traspaso_id}','TraspasosController@autorizar');
});

Route::group(['prefix'=>'/dashboard'],function(){

	Route::get('traspaso/buscar/producto/{filtro?}/{traspaso?}','ProductsController@searchLIKETraspaso');
	Route::get('seleccionar-sucursal','TraspasosController@bussineSelect');
	Route::get('seleccionar-productos/{traspaso_id}','TraspasosController@productsSelect');
	Route::post('agregar-producto-traspaso','ProductTraspasosController@store');
	Route::post('traspaso/terminar','TraspasosController@terminar');

	Route::put('aceptar/traspaso/{traspaso_id}','TraspasosController@aceptar');

	Route::get('buscar/inventario/{filtro?}','ProductsController@search')->middleware('cors');

	Route::get('vender','DashBoardController@vender');
	Route::group(['prefix'=>'orden/'],function(){
		Route::get('total','OrderController@total')->middleware('cors');
		Route::get('productos','ProductsOrderController@products');
		Route::post('agregar/producto','ProductsOrderController@store');
		Route::post('producto/inventario','ProductsOrderController@store2');

		Route::get('products/{search?}','ProductsOrderController@search');
		Route::post('productos_orden/delete/','ProductsOrderController@destroy');

	});
	Route::group(['prefix'=>'venta'],function(){
		Route::post('/','SalesController@store');
		Route::get('/{ticket?}','SalesController@ticketSale');
	});

	/*Route::get('orders/products','OrderController@products');
	Route::get('order/total','OrderController@total');
	Route::resource('productos_orden','ProductsOrderController')->only('store');
	Route::post('productos_orden/delete','ProductsOrderController@destroy');
	Route::get('sale/products/{search?}','ProductsOrderController@search');

	Route::post('venta','SalesController@store');

	Route::get('venta/{ticket?}','SalesController@ticketSale');*/
});

Route::post('regresar_traspaso','TraspasosController@regresar');

Route::get('vender','DashBoardController@vender');

Route::group(['prefix'=>'administrador','middleware'=>'auth'],function(){

	Route::resource('productos','ProductsController');
	Route::get('/producto/{categoria?}','ProductsController@searchByCategory');
	Route::resource('categorias','CategoriasController');
	Route::get('/producto_/{sucursal?}','ProductsController@searchByBussine');
	Route::resource('/sucursales','BussinesController');
	Route::get('/sucursales/{bussine_id}/productos','BussinesController@products');
	Route::resource('/ventas','SalesController');
	Route::resource('/usuarios','UsuariosController');
	Route::get('/perfil/{id?}','UsuariosController@profile');
	Route::resource('traspasos','TraspasosController');

	Route::resource('colores','ColorController');
	
	Route::get('precios/{product_id}','ChanchePriceController@change');
	Route::post('cambiar_precio','ChanchePriceController@changePrice');
});

Route::group(['prefix'=>'vendedor','middleware'=>'auth'],function(){

	Route::resource('productos','ProductsController');
	Route::resource('/ventas','SalesController');
	Route::get('/perfil/{id?}','UsuariosController@profile');
	Route::resource('traspasos','TraspasosController');

});
Route::resource('administrador/marcas','MarcasController');
Route::get('servicios','ServiciosController@index');
Route::get('servicios/{venta_id}','ServiciosController@create');
Route::post('servicios','ServiciosController@store');
Route::get('servicio/{servicio_id}','ServiciosController@show');

Route::get('reportes','ReportesController@index');
Route::post('reportes/inventario','ReportesController@inventario');

Route::get('reportes/servicios/{servicio_id}','ReportesController@servicios');
Route::post('reportes/servicios_dia','ReportesController@serviciosDia');

Route::get('facturacion','FacturacionController@index');