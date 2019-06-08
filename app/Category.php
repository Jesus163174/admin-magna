<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';

    public static function procedureIndex(){
    	return DB::select('call get_categories');
    }

    public static function countCategories(){
    	return DB::table('categorias')->count();
    }
}
