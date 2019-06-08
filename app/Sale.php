<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Sale extends Model{
    
    protected $table = 'ventas';
    protected $primaryKey = 'id';

    public function user(){
    	return $this->belongsTo('App\User','usuario_id');
    }
    public static function countSales(){
        if(Auth::user()->rol == 'administrador')
            return Sale::count();
        else
            return Sale::joinOrder()->byBussine()->count();

    }
    public static function getAllSales(){
        if(Auth::user()->rol == 'administrador')
            return Sale::getAllSalesOBJ()->selectData()->orderBySaleID();
        else
            return Sale::getAllSalesOBJ()->selectData()->byBussine()->orderBySaleID();
    }
    public function scopeGetAllSalesOBJ($query){
    	return $query->joinUser()->joinBussine();
    }
    public function scopeJoinUser($query){
        return $query->join('users','ventas.user_id','users.id');
    }
    public function scopeJoinOrder($query){
        return $query->join('orders','ventas.order_id','orders.id');
    }
    public function scopeJoinBussine($query){
        return $query->join('orders','ventas.order_id','orders.id')
        ->join('bussines','orders.bussine_id','bussines.id');
    } 
    public function scopeByBussine($query){
        return $query->where('orders.bussine_id',Auth::user()->bussine_id);
    }
    public function scopeSelectData($query){
        return $query->select(
            'ventas.id as ventaID',
            'ventas.total',
            'users.name as vendedor',
            'ventas.status',
            'ventas.tSale',
            'bussines.nombre as bussine',
            'ventas.date'
        );
    }
    public function scopeOrderBySaleID($query){
        return $query->orderBy('ventas.id','desc');
    }
    public static function getSalesLike($txtbuscar){
    	$sales = DB::table('ventas')
    	->join('users','ventas.user_id','users.id')
        ->join('orders','ventas.order_id','orders.id')
        ->join('bussines','orders.bussine_id','bussines.id')
    	->where('users.name','LIKE',"%$txtbuscar%")
    	->orWhere('ventas.status','LIKE',"%$txtbuscar%")
    	->orWhere('ventas.total','LIKE',"%$txtbuscar%")
    	->orWhere('ventas.id','LIKE',"%$txtbuscar%")
    	->select(
    		'ventas.total',
    		'ventas.user_id',
    		'ventas.total',
    		'ventas.discount as descuento',
    		'ventas.id as ventaID',
    		'ventas.status',
    		'users.name as vendedor',
            'bussines.nombre as bussine',
            'ventas.date'
    	);
    	return $sales;
    }
    public function scopeGetSalesBetween($query,$start,$end){
        return $query->joinUser()->joinBussine()->whereBetween('ventas.date', [$start, $end]);
    }

}
