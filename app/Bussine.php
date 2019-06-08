<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Bussine extends Model
{
	protected $table = 'bussines';
	protected $primaryKey = 'id';
    
    public static function procedureIndex(){
        return DB::select('call get_bussines_index');
    }

    public function scopeGetBussines($query){
    	return $query->where('estatus','activo');
    }
    public function scopeOrderBy($query){
    	return $query->orderBy('id','desc');
    }
    public function scopeGetBussinesLessYou($query){
        return $query->where('id','<>',Auth::user()->bussine_id)->select('id','nombre','calle','colonia','estado','pais','ciudad','numero_exterior','numero_interior');
    }
    public static function createNewBussine($request){
    	return DB::table('bussines')->insert(
    		[
    			'nombre'=>$request->nombre,
    			'calle'=>$request->calle,
    			'colonia'=>$request->colonia,
    			'estado'=>$request->estado,
    			'ciudad'=>$request->ciudad,
    			'pais'=>$request->pais,
    			'numero_interior'=>$request->interior,
    			'numero_exterior'=>$request->exterior,
    			'caja'=>$request->caja,
    			'tarjeta'=>$request->tarjeta,
    			'comision_taller'=>$request->comision
    		]
    	);
    }
    public static function updateBussine($id,$request){
    	return DB::table('bussines')->where('id',$id)->update(
    		[
    			'nombre'=>$request->nombre,
    			'calle'=>$request->calle,
    			'colonia'=>$request->colonia,
    			'estado'=>$request->estado,
    			'ciudad'=>$request->ciudad,
    			'pais'=>$request->pais,
    			'numero_interior'=>$request->interior,
    			'numero_exterior'=>$request->exterior,
    			'caja'=>$request->caja,
    			'tarjeta'=>$request->tarjeta
    		]
    	);
    }
    public static function countBussines(){
        return DB::table('bussines')->where('estatus','activo')->count();
    }
}
