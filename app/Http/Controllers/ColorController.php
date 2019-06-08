<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Color;
class ColorController extends Controller{

    public function index()
    {
        $colors = Color::get();
        return view('colors.index',compact('colors'));
    }
    public function create(){
        $marcas = Marca::all();
        $color = new Color();
        return view('colors.create',compact('marcas','color'));
    }
    public function store(Request $request){
        try{
            $color = new Color();
            $color->store($request->all());
            $msj = "Color agregado correctamente";
            return redirect('administrador/colores')->with('status_success',$msj);
        }catch(Exception $e){
            return back()->with("status_danger",$e->getMessage());
        }
    }
    public function show($id){
        //
    }
    public function edit($id){
        $color = Color::find($id);
        $marcas = Marca::all();
        return view('colors.edit',compact('color','marcas'));
    }
    public function update(Request $request, $id)
    {
        try{
            $color = Color::find($id);
            $color->edit($color,$request->all());
            $msj ="El color fue actualizado correctamente";
            return redirect('administrador/colores')->with('status_success',$msj);
        }catch(Exception $e){
            return back()->with("status_danger",$e->getMessage());
        }
    }
    public function destroy($id)
    {
        //
    }
}
