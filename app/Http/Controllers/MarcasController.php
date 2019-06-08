<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Auth;
use App\Marca;
class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Marca::all();
        return view('marcas.index',compact('brands'));
    }
    public function create()
    {
        $brand = new Marca();
        $operacion = 0;
        $url = "marcas/";
        return view('marcas.create',compact('brand','operacion','url'));
    }

    
    public function store(Request $request)
    {
        $marca = new Marca;
        $marca->nombre = $request->nombre;
        $marca->save();
        $msj = "La marca fue agregada correctamente";
        return redirect(Auth::user()->rol.'/colores/create')->with('status_success',$msj);
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Marca::find($id);
        $operacion = 1;
        $url = "marcas/".$id;
        return view('marcas.create', compact('brand', 'operacion', 'url'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->nombre = $request->nombre;
        $marca->save();
        $msj = "La marca fue actualizada correctamente";
        return redirect(Auth::user()->rol . '/marcas')->with('status_success', $msj);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
