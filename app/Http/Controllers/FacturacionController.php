<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use Auth;
class FacturacionController extends Controller
{
    public function index(){
        //facturacion del dia
        $ventas = Sale::join('orders','ventas.order_id','orders.id')
        ->join('users','orders.user_id','users.id')
        ->join('bussines','orders.bussine_id','bussines.id')
        ->select('ventas.id as ventaID','ventas.total','ventas.date','users.name as vendedor','bussines.nombre as bussine','ventas.status')
        ->where([['ventas.factura',0],['orders.bussine_id',Auth::user()->bussine_id]])
        ->get();
        return view('facturacion.index',compact('ventas'));
    }
}
