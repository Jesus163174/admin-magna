<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Bussine;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\PaginatorController;
class CategoriasController extends Controller{

    public function index()
    {
        $categories = Category::procedureIndex();
        return view('categories.index',compact('categories'));
    }
    public function create(){
        return view('categories.create');
    }
    public function store(Request $request)
    {
        try{
            $category = new Category;
            $category->nombre = $request->nombre;
            $category->save();
             $mensaje = "La categoria fue agregada correctamente";
            return redirect('dashboard/v/admin/categorias')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
        
    }
    public function show($id)
    {
        $category   =  Category::find($id);
        $products   =  Product::procedureProductsByCategory($category->id);
        $categories = Category::procedureIndex();
        $bussines   = Bussine::all();
        return view('categories.show',compact('category','products','categories','bussines'));
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit',compact('category'));
    }
    public function update(Request $request, $id)
    {
        try{
            $category = Category::find($id);
            $category->nombre = $request->nombre;
            $category->save();
            $mensaje = "La categoria fue actualizada correctamente";
            return redirect('dashboard/v/admin/categorias')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
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
