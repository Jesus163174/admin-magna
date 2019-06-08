<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Product extends Model{

    protected $table = 'inventarios';
    protected $primaryKey = 'id';

    public function category(){
    	return $this->belongsTo('App\Category','categoria_id');
    }
    public function bussine(){
    	return $this->belongsTo('App\Bussine');
    }
    public function color(){
        return $this->belongsTo('App\Color');
    }
    public function marca(){
        return $this->belongsTo('App\Marca','brand_id');
    }
    public static function procedureIndex(){
        if(Auth::user()->rol == 'administrador')
            return DB::select('call get_products_index');
        return DB::select('call get_products_index_seller(?)',array(Auth::user()->bussine_id));
    }
    public static function procedureSearchBySomething($toSearch){
        return DB::select('call search_product_by_something(?)',array($toSearch));
    }
    public static function procedureSearchBySomethingSeller($toSearch){
        return DB::select('call search_product_by_something_seller(?,?)',array($toSearch,Auth::user()->bussine_id));
    }
    public static function procedureProductsByCategory($category_id){
        return DB::select('call get_product_by_category(?)',array($category_id));
    }
    public static function procedureProductsByBussine($bussine_id){
        return DB::select('call get_product_by_bussine(?)',array($bussine_id));
    }
    public static function getProducts(){
        if(Auth::user()->rol == 'administrador')
            return Product::getProductsOBJ()->selectData()->orderByID();
        else
            return Product::getProductsOBJ()->selectData()->orderByID()->byBussine();
    }
    public function scopeGetProductsOBJ($query){
    	return $query->joinCategory()->joinBussine()->where('inventarios.estatus','activo');
    }
    public function scopeOrderByID($query){
    	return $query->orderBy('inventarios.id','desc');
    }
    public function scopeJoinCategory($query){
        return $query->join('categorias','inventarios.categoria_id','categorias.id');
    }
    public function scopeJoinBussine($query){
        return $query->join('bussines','inventarios.bussine_id','bussines.id');
    }
    public function scopeByBussine($query){
        return $query->where('inventarios.bussine_id',Auth::user()->bussine_id);
    }
    public function scopeSelectData($query){
        return $query->select(
            'inventarios.id',
            'inventarios.nombre as producto',
            'inventarios.codigo',
            'inventarios.existencia as stock',
            'inventarios.costo',
            'inventarios.precio_Venta as venta',
            'inventarios.clave_unidad',
            'inventarios.clave_producto',
            'categorias.nombre as categoria',
            'bussines.nombre as sucursal',
            'bussines.id as sucursal_id',
            'categorias.id as categoria_id',
            'inventarios.iva'
        );
    }
    public function scopeFinder($query,$id){
        return $query->where('inventarios.id',$id);
    }
    public function scopeByCategory($query,$category){
        return $query->where('inventarios.categoria_id',$category);
    }
    public function scopeGetLIKECategory($query,$category){
        return $query->where('inventarios.categoria_id',$category);
    }
    public function scopeGetLIKEBussine($query,$bussine){
        return $query->where('inventarios.bussine_id',$bussine);
    }
    public function scopeGetLIKE($query,$buscar){
        return $query->LIKEName($buscar)->LIKEClaveProduct($buscar)->LIKEClaveOne($buscar)->LIKECodigo($buscar);
    }
    public function scopeLIKEName($query,$name){
        return $query->where('inventarios.nombre','LIKE',"%$name%");
    }
    public function scopeLIKEClaveProduct($query,$clave){
        return $query->orWhere('inventarios.clave_producto','LIKE',"%$clave%");
    }
    public function scopeLIKEClaveOne($query,$clave){
        return $query->orWhere('inventarios.clave_unidad','LIKE',"%$clave%");
    }
    public function scopeLIKECodigo($query,$codigo){
        return $query->orWhere('inventarios.codigo',$codigo);
    }
    public static function createNewProduct($request){
        return DB::table('inventarios')->insert(
            [
                'nombre'=>$request->nombre,
                'codigo'=>$request->codigo,
                'existencia'=>$request->existencia,
                'costo'=>$request->costo,
                'precio_Venta'=>$request->precio_Venta,
                'bussine_id'=>$request->bussine_id,
                'categoria_id'=>$request->category_id,
                'iva'=>$request->iva,
                'clave_unidad'=>$request->clave_unidad,
                'clave_producto'=>$request->clave_producto,
                'brand_id'=>$request->marca_id,
                'provider_id'=>1,
                'color_id'=>$request->color_id
            ]
        );
    }
    public static function updateProduct($id,$request){
        return DB::table('inventarios')->where('id',$id)->update(
            [
                'nombre'=>$request->nombre,
                'codigo'=>$request->codigo,
                'existencia'=>$request->existencia,
                'costo'=>$request->costo,
               
                'bussine_id'=>$request->bussine_id,
                'categoria_id'=>$request->category_id,
                'iva'=>$request->iva,
                'clave_unidad'=>$request->clave_unidad,
                'clave_producto'=>$request->clave_producto,
                'brand_id'=>$request->marca_id,
                'color_id'=>$request->color_id,
                 'provider_id'=>1
            ]
     );
    }
    public static function countProducts(){
        return DB::table('inventarios')->where('estatus','activo')->count();
    }
    public static function stockAvailable($stock,$amount){

        if($stock >= $amount)
            return true;
        return false;
    }
    public function scopeGetProductByCode($query,$code){
        return $query->where('codigo',$code)->select('id','precio_Venta','existencia');
    }

    public static function issetOnBusine($productID,$busine){
        $product = Product::find($productID);
    }

}
