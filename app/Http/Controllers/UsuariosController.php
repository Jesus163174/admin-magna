<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\User;
use App\Bussine;
use Auth;
class UsuariosController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::procedureIndex(); 
        return view('users.index',compact('users'));
    }
    public function create(){
        $bussines = Bussine::getBussines()->get();
        return view('users.create',['bussines'=>$bussines]);
    }
    public function store(UserStoreRequest $request){
        try{
            $user = User::createNewUser($request);
            $mensaje = "El usuario a sido agregado correctamente";
            return redirect(Auth::user()->rol.'/usuarios')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
        
    }
    public function edit($id){
        //
    }
    public function update(Request $request, $id){
        try{
            User::updateUser($id,$request);
            $user = User::find($id);
            $mensaje = "El usuario ".$user->name." a sido actualizado correctamente";
            return redirect('dashboard/v/admin/usuarios')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
    }
    public function destroy($id)
    {
        //
    }
    public function profile(Request $request){
        $user = User::procedureShow($request->id);
        $user = collect($user)->first();
        return view('users.profile',compact('user'));
    }
}
