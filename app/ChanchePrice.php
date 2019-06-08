<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChanchePrice extends Model
{
    protected $table = 'prices';
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    public function scopeChange($query,$productID){
        return $query->where('product_id',$productID)->orderBy('date','desc');
    } 
}
