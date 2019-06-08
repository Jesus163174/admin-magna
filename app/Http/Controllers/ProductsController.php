<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\roductsRequest;
use App\Product;
use App\Bussine;
use App\Category;
use App\ProductoTraspaso;
use App\Traspaso;
use DB;
use App\Marca;
use Illuminate\Support\Facades\Input;
use App\Color;
use App\Http\Controllers\SearcherProductsController;
use App\Http\Controllers\PaginatorController;
class ProductsController extends Controller{

    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('userRol')->except(['index']);
    }

    /*
        metodo que trae todo el inventantario para el administrador
        pero para los vendedores solamente los de su sucursal,
        tambien implementa el buscador de productos igualemnte para 
        administradores y vendedores.
    */
    public function index(Request $request){
        
       
        $products = product::get();
        $categories   =  Category::procedureIndex();
        $bussines     = Bussine::procedureIndex();
        return view('products.index',compact('products','categories','bussines'));
    }

    public function searchByCategory(Request $request){

        $products   =  Product::procedureProductsByCategory($request->categoria);
        $categories =  Category::procedureIndex();
        $bussines   = Bussine::procedureIndex();
        return view('products.index',compact('products','categories','bussines'));
    }
    public function searchByBussine(Request $request){
        $products   = Product::procedureProductsByBussine($request->sucursal);
        $categories = Category::procedureIndex();
        $bussines   = Bussine::procedureIndex();
        return view('products.index',compact('products','categories','bussines'));
    }
    public function searchLIKE(Request $request){
        $products   = Product::getProducts()->getLIKE($request->filtro)->selectData()->orderByID()->paginate(7);
        $categories = Category::all();
        $bussines   = Bussine::all();
        return view('products.index',compact('products','categories','bussines'));
    }
    public function searchLIKETraspaso(Request $request){
        $products = Product::getProducts()->getLIKE($request->filtro)->byBussine()->selectData()->orderByID()->paginate(100);
        $products_traspasos = ProductoTraspaso::join('inventarios','producto_traspasos.producto_id','inventarios.id')
        ->select('inventarios.nombre as producto','producto_traspasos.cantidad')
        ->where('producto_traspasos.traspaso_id',$request->traspaso)->get();
        $traspaso = Traspaso::getTraspasos()->finder($request->traspaso)->selectData()->first();
        return view('traspasos.create',compact('products','products_traspasos','traspaso'));
    }
    public function create(Request $request){
        $color = null;
        $imei = '';
        $bussines = Bussine::getBussines()->get();
        $categories = Category::all();
        $marcas = Marca::all();
      
        if($request->imei != null){
            $color = Color::colorsByCode($request->imei)->first();
            $imei = $request->imei;
        }
        
        return view('products.create',compact('bussines','categories','marcas','color','imei'));
    }
    public function returnData($bussines,$categories,$marcas,$selectedBrand){
        $modelos = DB::table('modelo')->where('marca_id',$selectedBrand)->get();
        $colores = DB::table('colores')->where('marca_id',$selectedBrand)->get();
        $data = array(
            'modelos' => $modelos,
            'colores' => $colores
        );
        return $data;
    }
    public function store(Request $request){
        try{
            //dd($request);
            Product::createNewProduct($request);
            $mensaje = "El producto fue agregado exitosamente";
            return redirect('/dashboard/v/admin/productos')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id,Request $request)
    {
        $product = Product::find($id);
        $bussines   = Bussine::get();
        $color = null;
        $imei = '';
       
        
        $categories = Category::all();
      
        if($request->imei != null){
            $color = Color::colorsByCode($request->imei)->first();
            $imei = $request->imei;
        }
        return view('products.edit',compact('bussines','categories','product','color','imei'));
    }
    public function update(Request $request, $id)
    {
        
        try{
            Product::updateProduct($id,$request);
            $mensaje = "El producto fue actualizado exitosamente";
            return back()->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try{
            $productOrder = DB::table('product_orders')->where('product_id',$id)->delete();
            Product::destroy($id);
            $mensaje = "El producto fue eliminado correctamente";
            return redirect('/dashboard/v/admin/productos')->with('status_success',$mensaje);
        }catch(\Exception $e){
            dd($e);
        }
    }
}
