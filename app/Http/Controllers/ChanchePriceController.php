<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ChanchePrice;
use Auth;
class ChanchePriceController extends Controller
{
    public function index(){
        return view('prices.index');
    }
    public function change($productID){
        $product = Product::find($productID);
        $prices  = ChanchePrice::change($productID)->get();
        return view('prices.change',compact('product','prices'));
    }

    public function changePrice(Request $request){
        $product = Product::find($request->productID);

        $save = new ChanchePrice();
        $save->price = $product->precio_Venta;
        $save->date  = now();
        $save->user_id = Auth::user()->id;
        $save->product_id = $product->id;
        $save->save();

        $product->precio_Venta = $request->price;
        $product->save();

        return back();


    }
}
