<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Auth;
use DB;
class ProductOrder extends Model
{
    protected $fillable = ['order_id','product_id','amount','price','subtotal'];

    public static function procedureGetProductsOrder($orderID){
        return DB::select('call get_products_order(?)',array($orderID));
    }

    public static function getOrCreateProductInOrders($code,$amount){
        //existe producto en el inventario
        $product = Product::LIKECodigo($code)->byBussine()->first();
        if($product == null)
            return "false";
        $product = ProductOrder::getProductsOrder(\Session::get('orderID'))->byCode($code)->first();
        if(count($product)==1)
            //actualizar producto en la order
            return ProductOrder::updateProductInOrder($product,$amount,$code);
        else
            //aagregar producto en la orden
            return ProductOrder::addProductInOrder($product,$code,$amount);
    }
    public function scopeGetProductsOrder($query,$orderID){
        return $query->byOrder($orderID)->joinProducts()->selectData()->orderID();
    }
    public function scopeByOrder($query,$orderID){
        return $query->where('product_orders.order_id',$orderID);
    }
    public function scopeJoinProducts($query){
        return $query->join('inventarios','product_orders.product_id','inventarios.id');
    }
    public function scopeSelectData($query){
        return $query->select(
            'product_orders.id',
            'product_orders.amount',
            'product_orders.subtotal',
            'product_orders.price',
            'inventarios.nombre as producto'
        );
    }
    public function scopeOrderID($query){
        return $query->orderBy('product_orders.id','desc');
    }
    public function scopeByCode($query,$code){
        return $query->where('inventarios.codigo',$code);
    }
    public static function updateProductInOrder($product,$amount,$code){
        $product_inventario = Product::LIKECodigo($code)->select('existencia','id','precio_Venta')->first();
        if($product_inventario->existencia >= ($amount+$product->amount)){
            $product->amount +=$amount;
            $product->subtotal = (($product->amount)*$product->price);
            $product->save();
            return $product;
        }else{
            return "false";
        }
        
    }
    public static function addProductInOrder($product,$code,$amount){
        $product = Product::LIKECodigo($code)->byBussine()->select('existencia','id','precio_Venta')->first();
      
        if(count($product)==1){
            return ProductOrder::verifyStock($product,$amount);
        }else{
            return "false";
        }
    }
    public static function verifyStock($product,$amount){
        
        if($product->existencia >= $amount){
            return ProductOrder::createInOrder($product,$amount);
        }else{
            
            return "false";
        }
    }
    public static function createInOrder($product,$amount){
        return ProductOrder::create([
            'product_id'=>$product->id,
            'amount'=>$amount,
            'order_id'=>\Session::get('orderID'),
            'subtotal'=>$product->precio_Venta * $amount,
            'price'=>$product->precio_Venta
        ]);
    }

    
    

    /*public static function getProducts($orderID){
    	return DB::table('product_orders')
    	->join('inventarios','product_orders.product_id','inventarios.id')
    	->select(
    		'inventarios.id',
    		'inventarios.nombre as product',
    		'product_orders.amount',
    		'product_orders.subtotal',
    		'product_orders.price'
    	)->where('product_orders.order_id',$orderID)->orderBy('product_orders.created_at','desc')->get();
    }
    public static function getProductsOnSale($search){
        return DB::table('product_orders')
        ->where('product_orders.order_id',\Session::get('orderID'))
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->where('inventarios.nombre','LIKE',"%$search%")
        ->orWhere('inventarios.codigo','LIKE',"%$search%")
        ->select(
            'inventarios.id',
            'inventarios.nombre as product',
            'product_orders.amount',
            'product_orders.subtotal',
            'product_orders.price',
            'product_orders.order_id'
        )->get();
    }
    public static function getProduct($code){
    	$product = Product::LIKECodigo($code)->getLIKEBussine(Auth::user()->bussine_id)->first();
    	return $product;
    }
    public static function createOrUpdateProduct($product){
    	$issetProductInOrder = ProductOrder::issetProduct($product->id);
    	if(count($issetProductInOrder) == 0)
    		return ProductOrder::createProductInOrder($product);
    	return ProductOrder::updateProductInOrder($issetProductInOrder);
    }
    public static function issetProduct($productID){
    	$product = ProductOrder::where([['product_id',$productID],['order_id',\Session::get('orderID')]])->first();
        return $product;
    }
    public static function createProductInOrder($product){
    	try{
    		$product_add = new ProductOrder;
    		$product_add->amount     = 1;
    		$product_add->subtotal   = $product->precio_Venta; 
    		$product_add->product_id = $product->id;
    		$product_add->order_id   = $product->order_id;
    		$product_add->price      = $product->precio_Venta;
    		$product_add->save();
    		return "correcto";
    	}catch(\Exception $e){
    		return $e;
    	}
    }
    public static function updateProductInOrder($product){
    	try{
    		$product->amount +=1;
	    	$product->subtotal = (($product->amount+1)*($product->price));
	    	$product->save();
	    	return "correcto";
    	}catch(\Exception $e){
    		return $e;
    	}
    }*/
}
