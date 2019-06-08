<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Http\Request;
use App\Sale;
use Auth;
use Carbon\Carbon;
use App\Order;
use App\ProductOrder;
use App\Bussine;
use App\Product;
use DB;
use App\User;
class SalesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $count = Sale::countSales();
        $invertedMoney = DB::table('inventarios')->
        select(DB::raw('sum(costo*existencia) as invertido'))->first();
        $ganancias = Sale::join('orders','ventas.order_id','orders.id')
        ->join('product_orders','orders.id','product_orders.order_id')
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            DB::raw('sum((inventarios.precio_Venta-inventarios.costo)*product_orders.amount) as ganancias')
        )->where('ventas.date',Carbon::now()->format('Y-m-d'))->get();
        $invertedMoney = number_format($invertedMoney->invertido,2,'.',',');
        $ganancias = number_format($ganancias[0]->ganancias,2,'.',',');
        $sales = Sale::getAllSales()->get();
        return view('sales.index',compact('sales','count','invertedMoney','ganancias'));
    }
    public function ticketSale(Request $request){
        $bussine = Bussine::find(Auth::user()->bussine_id);
        $sale = Sale::find($request->ticket);
        $order = Order::find($sale->order_id);
        $products = ProductOrder::join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            'inventarios.nombre as producto',
            'inventarios.precio_Venta as precio',
            'product_orders.amount as cantidad',
            'product_orders.subtotal',
            'inventarios.codigo','inventarios.precio_Venta as venta'
        )->where('product_orders.order_id',$order->id)->get();

        $total = $order->subtotal;
        $discount = 0;
        $dinDiscount = 0;
        $pay = 0;
        $porPay = 0;
        $typePay = "efectivo";
                 //tarjeta dinero que se paga de mas
        if($order->pay != 0){
            $typePay = "tarjeta";
            $total += ($order->subtotal * $order->pay)/100;
                    //porcentaje tarjeta
            $porPay = Bussine::find(Auth::user()->bussine_id)->tarjeta;
        }
                //descuento porcentaje
        if($order->discount !=0){
            $discount = $order->discount;
                    //dinero descontado
            $dinDiscount = ($order->subtotal *$order->discount)/100;
            $total -= $dinDiscount;
        }
        $subtotal = $order->subtotal;

        $user = User::find($order->user_id);
        return view('dashboard.ticket',compact(
            'sale','products','total','discount','dinDiscount','pay','porPay','typePay','bussine','subtotal','user'
        ));
    }
    public function search(Request $request){
        $sales = Sale::getSalesLike($request->filtro_venta)->get();
        return view('sales.index',compact('sales'));
    }
    public function FilterBetweenDates(Request $request){
        $sales = Sale::getSalesBetween($request->date_start,$request->date_end)->selectData()->get();
        $fecha1 = $request->date_start;
        $fecha2 = $request->date_end;
        $reporte_fechas = true;
        return view('sales.index',compact('sales','fecha1','fecha2','reporte_fechas'));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
        try{
            $order = Order::getOrder(\Session::get('orderID'));
            \Session::put('orderID',$order->id);

            //total
            $total = $order->subtotal;
            $discount = 0;
            $dinDiscount = 0;
            $pay = 0;
            $porPay = 0;
            $typePay = "efectivo";
                 //tarjeta dinero que se paga de mas
            if($order->pay != 0){
                $typePay = "tarjeta";
                $total += ($order->subtotal * $order->pay)/100;
                    //porcentaje tarjeta
                $porPay = Bussine::find(Auth::user()->bussine_id)->tarjeta;
            }
                //descuento porcentaje
            if($order->discount !=0){
                $discount = $order->discount;
                    //dinero descontado
                $dinDiscount = ($order->subtotal *$order->discount)/100;
                $total -= $dinDiscount;
            }

            $sale = new Sale;
            $sale->user_id = Auth::user()->id;
            $sale->order_id = \Session::get('orderID');
            $sale->total    = $total;
            $sale->tSale    = $typePay;
            $sale->discount = $discount;
            $sale->status   = "pagado";
            $sale->pay      = $pay;
            $sale->date     = Carbon::now();
            $sale->cliente_id = $request->cliente_id;
            $sale->save();


            $products_order = DB::table('product_orders')->join('inventarios','product_orders.product_id','inventarios.id')
            ->where('product_orders.order_id',\Session::get('orderID'))
            ->select(
                'inventarios.id as product_id',
                'product_orders.amount'
            )->get();

            

            foreach ($products_order as $productOrder) {
                $product = Product::find($productOrder->product_id);
                $product->existencia -=$productOrder->amount;
                $product->save();
            }

            \Session::remove('orderID');
            if($request->tipo_venta != 1)
                return redirect('/dashboard/venta?ticket='.$sale->id);
            return redirect('/servicios/'.$sale->id);
        }catch(\Exception $e){
            dd($e);
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        $order = Order::find($sale->order_id);
        /*$products = ProductOrder::join('inventarios','product_orders.product_id','inventarios.id')->where([['order_id',$order->id]])
        ->select(
            'inventarios.nombre as producto',
            'inventarios.precio_Venta as venta',
            'product_orders.amount',
            'product_orders.subtotal',
            'inventarios.codigo'
        )->get();*/
        $products = ProductOrder::procedureGetProductsOrder($sale->order_id);
        return view('sales.show',compact('sale','order','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->status = "cancelado";
        $sale->save();

        //regresar al inventario
        $products_sale = ProductOrder::join('inventarios','product_orders.product_id','inventarios.id')
        ->where('product_orders.order_id',$sale->order_id)
        ->select(
            'inventarios.nombre as producto',
            'product_orders.amount',
            'inventarios.id'
        )->get();

       

        foreach ($products_sale as $product_sale) {
            $product = Product::find($product_sale->id);
            $product->existencia +=$product_sale->amount;
            $product->save();
        }
        return back();
    }

     public function reporte_venta_dia(){
        $sales = Sale::join('orders','ventas.order_id','orders.id')
        ->join('bussines','orders.bussine_id','bussines.id')
        ->join('users','orders.user_id','users.id')
        ->select(
            'ventas.id',
            'ventas.date as fecha',
            'ventas.total',
            'ventas.status',
            'users.name as vendedor',
            'bussines.nombre as bussine'
        )->where(
            [
                ['ventas.date',Carbon::now()->format('Y-m-d')],
                ['ventas.status','pagado'],
                ['orders.bussine_id',Auth::user()->bussine_id]
            ]
        )->get();

        $total_venta_dia = Sale::join('orders','ventas.order_id','orders.id')->where([['ventas.status','pagado'],['orders.bussine_id',Auth::user()->bussine_id],['ventas.date',Carbon::now()->format('Y-m-d')]])->sum('ventas.total');
        $invertido = DB::table('ventas')
        ->join('orders','ventas.order_id','orders.id')
        ->join('product_orders','orders.id','product_orders.order_id')
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            DB::raw('sum(inventarios.costo*product_orders.amount) as invercion_venta')
        )->where([['ventas.date',Carbon::now()->format('Y-m-d')],['orders.bussine_id',Auth::user()->bussine_id]])->get();

        $ganancias = $total_venta_dia - $invertido[0]->invercion_venta;

        /*$ganancias       = Sale::join('orders','ventas.order_id','orders.id')
        ->join('product_orders','orders.id','product_orders.order_id')
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            DB::raw('sum((inventarios.precio_Venta-inventarios.costo)*product_orders.amount) as ganancias')
        )->where('ventas.date',Carbon::now()->format('Y-m-d'))->get();*/

        $pdf = \App::make('dompdf.wrapper');

        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Reporte de ventas del dia</title>
            </head>
            <style>
                .clearfix:after {
                  content: "";
                  display: table;
                  clear: both;
                }

                a {
                  color: #5D6975;
                  text-decoration: underline;
                }

                body {
                  
                
                  height: 29.7cm; 
                  margin: 0 auto; 
                  color: #001028;
                  background: #FFFFFF; 
                  font-family: Arial, sans-serif; 
                  font-size: 12px; 
                  font-family: Arial;
                }

                header {
                  padding: 10px 0;
                  margin-bottom: 30px;
                }

                #logo {
                  text-align: center;
                  margin-bottom: 10px;
                }

                #logo img {
                  width: 90px;
                }

                h1 {
                  border-top: 1px solid  #5D6975;
                  border-bottom: 1px solid  #5D6975;
                  color: #5D6975;
                  font-size: 2.4em;
                  line-height: 1.4em;
                  font-weight: normal;
                  text-align: center;
                  margin: 0 0 20px 0;
                  background: url(dimension.png);
                }

                #project {
                  float: left;
                }

                #project span {
                  color: #5D6975;
                  text-align: right;
                  width: 52px;
                  margin-right: 10px;
                  display: inline-block;
                  font-size: 0.8em;
                }

                #company {
                  float: right;
                  text-align: right;
                }

                #project div,
                #company div {
                  white-space: nowrap;        
                }

                table {
                  width: 100%;
                  border-collapse: collapse;
                  border-spacing: 0;
                  margin-bottom: 20px;
                }

                table tr:nth-child(2n-1) td {
                  background: #F5F5F5;
                }

                table th,
                table td {
                  
                }

                table th {
                  padding: 5px 20px;
                  color: #5D6975;
                  border-bottom: 1px solid #C1CED9;
                  white-space: nowrap;        
                  font-weight: normal;
                }

                table .service,
                table .desc {
                
                }

                table td {
                  padding: 20px;
                 
                }

                table td.service,
                table td.desc {
                  vertical-align: top;
                }

                table td.unit,
                table td.qty,
                table td.total {
                  font-size: 1.2em;
                }

                table td.grand {
                  border-top: 1px solid #5D6975;;
                }

                #notices .notice {
                  color: #5D6975;
                  font-size: 1.2em;
                }

                footer {
                  color: #5D6975;
                  width: 100%;
                  height: 30px;
                  position: absolute;
                  bottom: 0;
                  border-top: 1px solid #C1CED9;
                  padding: 8px 0;
                  text-align: center;
                }
            </style>
            <body>
                <header class="clearfix">
                    <div id="logo">
                        <img src="https: //scontent.ftgz1-1.fna.fbcdn.net/v/t1.0-9/55547007_673429456404743_8159167067476459520_n.jpg?_nc_cat=110&_nc_eui2=AeEobwTS0yHofdS0Uxb_1cUdzYtf1h9ybab3GbUTnKKIKU19uzqNrSkkoMMANR1p91swMz7X_weYxt_NZrW8915gX57JNkeljJfMbMAian0ybQ&_nc_ht=scontent.ftgz1-1.fna&oh=aa7e31e4834f8001ea651e0cca2f6a67&oe=5D3D85D1">
                    </div>
                     <h1>Reporte Realizado: '.Carbon::now()->format("Y-m-d").'</h1>
                    <div id="company" class="clearfix">
                        <div>Company Name</div>
                        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
                        <div>(602) 519-0450</div>
                        <div><a href="mailto:company@example.com">company@example.com</a></div>
                    </div>
                    <div id="project">
                        <div><span>REPORTE</span> REPORTETE DEL DIA </div>
                        <div><span>USUARIO</span> '.Auth::user()->name.'</div>
                        <div><span>SUCURSAL</span> '.Auth::user()->bussine->nombre.'</div>
                        <div><span>FECHA</span> '.Carbon::now()->format("Y-m-d").'</div>
                        <div><span>TOTAL</span> $'.number_format($total_venta_dia,2,'.',',').'</div>
                        <div><span>INVERCIÓN</span> $'.number_format($invertido[0]->invercion_venta,2,'.',',').'</div>
                        <div><span>GANACIAS</span> $'.number_format($ganancias,2,'.',',').'</div>
                        
                    </div>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;">FOLIO</th>
                                <th style="text-align:center;">Total</th>
                                <th style="text-align:center;">Sucursal</th>
                                <th style="text-align:center;">Vendedor</th>
                                <th style="text-align:center;">Fecha</th>
                                <th style="text-align:center;">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                    foreach ($sales as $key) {
                        $html .= '
                            <tr>
                                <td style="text-align:center;">'.$key->id.'</td>
                                <td style="text-align:center;">$'.$key->total.'</td>
                                <td style="text-align:center;">'.$key->bussine.'</td>
                                <td style="text-align:center;">'.$key->vendedor.'</td>
                                <td style="text-align:center;">'.$key->fecha.'</td>
                                <td style="text-align:center;">'.$key->status.'</td>
                            </tr>
                        ';
                    }
                    $html .='
                        </tbody>
                    </table>
                    
                </main>
            </body>
            </html>
        ';
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function reporte_fechas(Request $request){
        $sales = Sale::getSalesBetween($request->inicio,$request->final)->selectData()->byBussine()->get();
        $total_venta_dia = Sale::getSalesBetween($request->inicio,$request->final)->where('ventas.status','pagado')->byBussine()->sum('total');
        
        /*$ganancias = Sale::join('orders','ventas.order_id','orders.id')
        ->join('product_orders','orders.id','product_orders.order_id')
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            DB::raw('sum((inventarios.precio_Venta-inventarios.costo)*product_orders.amount) as ganancias')
        )->whereBetween('ventas.date', [$request->inicio, $request->final])->get();*/

        $invertido = DB::table('ventas')
        ->join('orders','ventas.order_id','orders.id')
        ->join('product_orders','orders.id','product_orders.order_id')
        ->join('inventarios','product_orders.product_id','inventarios.id')
        ->select(
            DB::raw('sum(inventarios.costo*product_orders.amount) as invercion_venta')
        )->where([['ventas.status','pagado'],['orders.bussine_id',Auth::user()->bussine_id]])->whereBetween('ventas.date', [$request->inicio,$request->final])->get();

        $ganancias = $total_venta_dia - $invertido[0]->invercion_venta;

        //return $invertido;
        $pdf = \App::make('dompdf.wrapper');
        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Reporte de ventas del dia</title>
            </head>
            <style>
                .clearfix:after {
                  content: "";
                  display: table;
                  clear: both;
                }

                a {
                  color: #5D6975;
                  text-decoration: underline;
                }

                body {
                  
                
                  height: 29.7cm; 
                  margin: 0 auto; 
                  color: #001028;
                  background: #FFFFFF; 
                  font-family: Arial, sans-serif; 
                  font-size: 12px; 
                  font-family: Arial;
                }

                header {
                  padding: 10px 0;
                  margin-bottom: 30px;
                }

                #logo {
                  text-align: center;
                  margin-bottom: 10px;
                }

                #logo img {
                  width: 90px;
                }

                h1 {
                  border-top: 1px solid  #5D6975;
                  border-bottom: 1px solid  #5D6975;
                  color: #5D6975;
                  font-size: 2.4em;
                  line-height: 1.4em;
                  font-weight: normal;
                  text-align: center;
                  margin: 0 0 20px 0;
                  background: url(dimension.png);
                }

                #project {
                  float: left;
                }

                #project span {
                  color: #5D6975;
                  text-align: right;
                  width: 52px;
                  margin-right: 10px;
                  display: inline-block;
                  font-size: 0.8em;
                }

                #company {
                  float: right;
                  text-align: right;
                }

                #project div,
                #company div {
                  white-space: nowrap;        
                }

                table {
                  width: 100%;
                  border-collapse: collapse;
                  border-spacing: 0;
                  margin-bottom: 20px;
                }

                table tr:nth-child(2n-1) td {
                  background: #F5F5F5;
                }

                table th,
                table td {
                  
                }

                table th {
                  padding: 5px 20px;
                  color: #5D6975;
                  border-bottom: 1px solid #C1CED9;
                  white-space: nowrap;        
                  font-weight: normal;
                }

                table .service,
                table .desc {
                
                }

                table td {
                  padding: 20px;
                 
                }

                table td.service,
                table td.desc {
                  vertical-align: top;
                }

                table td.unit,
                table td.qty,
                table td.total {
                  font-size: 1.2em;
                }

                table td.grand {
                  border-top: 1px solid #5D6975;;
                }

                #notices .notice {
                  color: #5D6975;
                  font-size: 1.2em;
                }

                footer {
                  color: #5D6975;
                  width: 100%;
                  height: 30px;
                  position: absolute;
                  bottom: 0;
                  border-top: 1px solid #C1CED9;
                  padding: 8px 0;
                  text-align: center;
                }
            </style>
            <body>
                <header class="clearfix">
                    <div id="logo">
                        <img src="https: //scontent.ftgz1-1.fna.fbcdn.net/v/t1.0-9/55547007_673429456404743_8159167067476459520_n.jpg?_nc_cat=110&_nc_eui2=AeEobwTS0yHofdS0Uxb_1cUdzYtf1h9ybab3GbUTnKKIKU19uzqNrSkkoMMANR1p91swMz7X_weYxt_NZrW8915gX57JNkeljJfMbMAian0ybQ&_nc_ht=scontent.ftgz1-1.fna&oh=aa7e31e4834f8001ea651e0cca2f6a67&oe=5D3D85D1">
                    </div>
                    <h1>Reporte Realizado: '.Carbon::now()->format("Y-m-d").'</h1>
                    <div id="company" class="clearfix">
                        <div>Company Name</div>
                        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
                        <div>(602) 519-0450</div>
                        <div><a href="mailto:company@example.com">company@example.com</a></div>
                    </div>
                    <div id="project">
                        <div><span>REPORTE</span> REPORTETE POR FECHAS DEL '.$request->inicio.' al '.$request->final.'</div>
                        <div><span>USUARIO</span> '.Auth::user()->name.'</div>
                        <div><span>SUCURSAL</span> '.Auth::user()->bussine->nombre.'</div>
                        <div><span>FECHA</span> '.Carbon::now()->format("Y-m-d").'</div>
                        <div><span>TOTAL</span> $'.number_format($total_venta_dia,2,'.',',').'</div>
                        <div><span>INVERCIÓN</span> $'.number_format($invertido[0]->invercion_venta,2,'.',',').'</div>
                        <div><span>GANACIAS</span> $'.number_format($ganancias,2,'.',',').'</div>
                        
                    </div>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;">FOLIO</th>
                                <th style="text-align:center;">Total</th>
                                <th style="text-align:center;">Estatus</th>
                                <th style="text-align:center;">Sucursal</th>
                                <th style="text-align:center;">Vendedor</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                    foreach ($sales as $key) {
                        $html .= '
                            <tr>
                                <td style="text-align:center;">'.$key->ventaID.'</td>
                                <td style="text-align:center;">$'.$key->total.'</td>
                                <td style="text-align:center;">'.$key->status.'</td>
                                <td style="text-align:center;">'.$key->bussine.'</td>
                                <td style="text-align:center;">'.$key->vendedor.'</td>
                            </tr>
                        ';
                    }
                    $html .='
                        </tbody>
                    </table>
                    
                </main>
            </body>
            </html>
        ';
        $pdf->loadHTML($html);
        return $pdf->stream();
        dd($sales);
    }
}
