<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Servicio;
use Carbon\Carbon;
use App\ProductOrder;
class ServiciosController extends Controller
{
	public function index(){
		$servicios = Servicio::procedureIndex();
		return view('servicios.index',compact('servicios'));
	}
    public function create($venta_id){
    	$venta = Sale::find($venta_id);
    	return view('servicios.create',compact('venta'));
    }
    public function store(Request $request){
    	try{
            $venta = Sale::find($request->venta_id);
            $request['total'] = $venta->total + $request->precio_mano_obre;
			$servicio = Servicio::create($request->all());	
			return redirect('servicio/'.$servicio->id);
    	}catch(\Exception $e){
    		dd($e);
    	}
    }
    public function show($servicioID){
    	$servicio = Servicio::find($servicioID);
    	$sale     = Sale::find($servicio->venta_id);
    	$products = ProductOrder::procedureGetProductsOrder($sale->order_id);
        //return response($servicio);
    	return view('servicios.show',compact('servicio','sale','products'));
    }
}
