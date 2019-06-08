<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Category;
use App\Bussine;
use App\Order;
use App\ProductOrder;
use DB;
use Carbon\Carbon;
use App\Client;
class DashBoardController extends Controller{

    public function index(){
    	$users    = User::countUsers();
    	$products = Product::countProducts();
    	$categories = Category::countCategories();
    	$bussines   = Bussine::countBussines();

        $grafica    = DB::select('call grafica_ventas(?)',array(Carbon::now()->format('Y-m-d')));
        //return $grafica;
    	return view('dashboard.index',compact('users','products','categories','bussines','grafica'));
    }
    public function vender(){
        $clients = Client::all();
        $order = Order::getOrder(\Session::get('orderID'));
        \Session::put('orderID',$order->id);
        //$productos = ProductOrder::getProductsOrder($order->id)->get();
        $productos = ProductOrder::procedureGetProductsOrder($order->id);

        $subtotal = ProductOrder::where('order_id',\Session::get('orderID'))->sum('subtotal');
        $order->subtotal = $subtotal;
        $order->status = "terminado";
        $order->save();

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
            'porPay'=>$porPay,
            'clients'=>$clients
        );
        
        return view('dashboard.vender',compact('productos','detail'));
    }
}
