<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';
    protected $fillable = ['color','imei','marca_id'];

    public function marca(){
        return $this->belongsTo('App\Marca');
    }

    public function store($request){
        return Color::create($request);
    }
    public function edit($color,$request){
        return $color->fill($request)->save();
    }

    public function scopeColorsByCode($query,$code){
        return $query->where('imei',$code);
    }
}
