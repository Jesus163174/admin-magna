<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Auth;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //METODOS DE LA CLASE
    public function bussine(){
        return $this->belongsTo('App\Bussine');
    }
    public function scopeGetUsers($query){
        return $query->where('status','activo');
    }
    public function scopeOrderByBussine($query){
        return $query->orderBy('bussine_id','asc');
    } 
    public function scopeSelect($query){
        return $query->select('id','name','email','status','bussine_id','rol');
    }
    public  function scopeGetUsersLIKE($query,$buscar){
        return $query->likeName($buscar)->likeEmail($buscar);
    }
    public function scopeLikeName($query,$buscar){
        return $query->where('name','LIKE',"%$buscar%");
    }
    public function scopeLikeEmail($query,$buscar){
        return $query->where('email','LIKE',"%$buscar%");
    }

    //METODOS ESTATICOS
    public static function getCredentialUsers($user_id){
        return User::where('id',$user_id);
    }
    public static function createNewUser($request){
        return DB::table('users')->insert(
            [
                'name'=>$request->name,
                'celular'=>$request->celular,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'rol'=>$request->rol,
                'bussine_id'=>$request->bussine_id,
               
                'created_at'=>Carbon::now()
            ]
        );
    }
    public static function updateUser($id,$request){
        return DB::table('users')->where('id',$id)->update(
            [
                'name'=>$request->name,
                'celular'=>$request->celular,
                'email'=>$request->email,
                'rol'=>$request->rol,
                'bussine_id'=>$request->bussine_id,
                
                'updated_at'=>Carbon::now()
            ]
        );
    }  
    public static function countUsers(){
        return DB::table('users')->count();
    }


    public static function procedureIndex(){
        return DB::select('call get_usuarios_index');
    }
    public static function procedureShow($user_id){
        return DB::select('call get_usuarios_show(?)',array($user_id));
    }
}
