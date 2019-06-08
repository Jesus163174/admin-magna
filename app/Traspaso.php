<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Traspaso extends Model
{
    
    public static function getTraspasos(){
    	if(Auth::user()->rol == 'administrador')
    		return Traspaso::getTraspasosOBJ()->orderByID();
    	else
    		return Traspaso::getTraspasosOBJ()->byBussine()->orderByID();
    }
    public function scopeGetTraspasosOBJ($query){
    	return $query->joinBussineSend()->joinBussineReceibe()->joinUserSend();
    }
    public function scopeJoinBussineSend($query){
    	return $query->join('bussines as bussine_envia','traspasos.envia','bussine_envia.id');
    }
    public function scopeJoinBussineReceibe($query){
    	return $query->join('bussines as bussine_recibe','traspasos.recibe','bussine_recibe.id');
    }
    public function scopeJoinUserSend($query){
    	return $query->join('users','traspasos.usuario_id','users.id');
    }
    public function scopeByBussine($query){
    	return $query->where('traspasos.envia',Auth::user()->bussine_id)->orWhere('traspasos.recibe',Auth::user()->bussine_id);
    }
    public function scopeOrderByID($query){
    	return $query->orderBy('traspasos.id','desc');
    }
    public function scopeFinder($query,$id){
        return $query->where('traspasos.id',$id);
    }
    public function scopeSelectData($query){
    	return $query->select(
    		'traspasos.id',
    		'traspasos.envia',
    		'traspasos.recibe',
    		'traspasos.usuario_id',
    		'traspasos.estatus',
    		'traspasos.created_at as fecha',
    		'bussine_recibe.nombre as suc_recibe',
    		'bussine_envia.nombre as suc_envia',
    		'users.name as usuario'
    	);
    }
}
