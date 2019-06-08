<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\ProductOrder;
class OrderController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
    public function products(){

    	return response(Auth::user());
        $order = Order::getOrder(\Session::get('orderID'));
        \Session::put('orderID',$order->id);
        
        $products = ProductOrder::getProducts($order->id);
        return response()->json($products);
    }
    public function total(){
    	try{
    		$order = Order::getOrder(\Session::get('orderID'));
	        \Session::put('orderID',$order->id);

	        $subtotal = ProductOrder::where('order_id',\Session::get('orderID'))->sum('subtotal');
	        $order->subtotal = $subtotal;
	        $order->status = "terminado";
	        $order->save();

	        //total
	        $total = $order->subtotal;
	        $discount = 0;
	        $dinDiscount = 0;
	        $pay = 0;
	        $porPay = 0;
	         //tarjeta dinero que se paga de mas
	        if($order->pay != 0){
	        	$total += ($order->subtotal * $order->pay)/100;
	        	//porcentaje tarjeta
	        	$porPay = Bussine::find(Auth::user()->bussine_id)->tarjeta;
	        }
	        //descuento porcentaje
	        if($order->discount !=0){
	        	$discount = $order->discount;
	        	//dinero descontado
	        	$dinDiscount = ($order->subtotal *$order->discount)/100;
	        	$total -= $dinDiscount;
	        }
	        //subtotal
	        $subtotal = $order->subtotal;

	        $detail = array(
	        	'total'=>$total,
	        	'discount'=>$discount,
	        	'cashDiscount'=>$dinDiscount,
	        	'subtotal'=>$subtotal,
	        	'pay'=>$pay,
	        	'porPay'=>$porPay
	        );
	        return response()->json($detail);
    	}catch(\Exception $e){
    		return response($e,401);
    	}
    }
}
