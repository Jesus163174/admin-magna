<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoTraspaso;
use App\Product;
use DB;
class ProductTraspasosController extends Controller
{
    
    public function store(Request $request){
    	$existe_en_traspaso = ProductoTraspaso::where([['traspaso_id',$request->traspaso_id],['producto_id',$request->producto_id]])->first();
    	if(count($existe_en_traspaso) == 0){
            $producto = Product::find($request->producto_id);
            if(!$producto->existencia >= $request->cantidad){
                return back()->with("status_warning","No te alcanza el producto para traspasar");
            }
    		$add = new ProductoTraspaso;
	    	$add->traspaso_id = $request->traspaso_id;
	    	$add->producto_id = $request->producto_id;
	    	$add->cantidad    = $request->cantidad;
	    	$add->save();
    	}else{
            $producto = Product::find($request->producto_id);
            
            if(!$producto->existencia >= $request->cantidad){
                return back()->with("status_warning","No te alcanza el producto para traspasar");
            }
    		$existe_en_traspaso->cantidad = $request->cantidad;
    		$existe_en_traspaso->save();
    	}
    	
    	return back();
    }

   
}
