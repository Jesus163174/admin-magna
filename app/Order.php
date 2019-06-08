<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
class Order extends Model{

	protected $fillable = ['user_id','bussine_id','date','subtotal','status','discount','pay'];

	public static function getOrder($orderID){
		if($orderID == null){
			return Order::createNewOrder();
		}else{
			return Order::FindOrder($orderID);
		}
	}
	public static function findOrder($orderID){
		return Order::find($orderID);
	}
	public static function createNewOrder(){
		return Order::create([
			'user_id'=>Auth::user()->id,
			'bussine_id'=>Auth::user()->bussine_id,
			'date'=>Carbon::now(),
			'subtotal'=>0.0,
			'status'=>'proceso',
			'pay'=>0.0,
			'discount'=>0.0
		]);
	}

}
