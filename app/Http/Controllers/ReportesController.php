<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Bussine;
use App\Product;
use Carbon\Carbon;
use Auth;
use App\Servicio;
use App\Sale;
use DB;
class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $sucursales = Bussine::all();
    	return view('reportes.index',compact('sucursales'));
    }
    public function inventario(Request $request){
    	//$productos = Product::procedureIndex();

    	
    	$sucursal="bodega";
    	if($request->sucursal_id == 0){
    		$productos = Product::join('categorias','inventarios.categoria_id','categorias.id')
    		->join('bussines','inventarios.bussine_id','bussines.id')
    		->select(
    			'inventarios.nombre',
    			'inventarios.codigo',
    			'inventarios.existencia as stock',
    			'inventarios.costo',
    			'inventarios.precio_Venta as venta',
    			'categorias.nombre as categoria',
    			'bussines.nombre as sucursal'
    		)->get();
    		$sucursal = "Reporte general de inventario";
    	}else{
			$productos = Product::join('categorias','inventarios.categoria_id','categorias.id')
    		->join('bussines','inventarios.bussine_id','bussines.id')
    		->select(
    			'inventarios.nombre',
    			'inventarios.codigo',
    			'inventarios.existencia as stock',
    			'inventarios.costo',
    			'inventarios.precio_Venta as precio',
    			'categorias.nombre as categoria',
    			'bussines.nombre as sucursal'
    		)->where('bussine_id',$request->sucursal_id)->get();
    		$sucursal = Bussine::find($request->sucursal_id)->nombre;
    	}

    	$pdf = \App::make('dompdf.wrapper');
    	$html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Reporte de inventarios</title>
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
                  
                  width:100%;
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
                    <h1>Reporte realizado: '.Carbon::now()->format('Y-m-d').'</h1>
                    <div id="company" class="clearfix">
                        <div>Company Name</div>
                        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
                        <div>(602) 519-0450</div>
                        <div><a href="mailto:company@example.com">company@example.com</a></div>
                    </div>
                    <div id="project">
                        <div><span>REPORTE</span> REPORTE DE INVENTARIO</div>
                        <div><span>USUARIO</span> '.Auth::user()->name.'</div>
                        <div><span>SUCURSAL</span> '.Auth::user()->bussine->nombre.'</div>
                        <div><span>FECHA</span> '.Carbon::now()->format('Y-m-d').'</div>
                        <div><span>INV SUCURSAL: </span> '.$sucursal.'</div>
                        
                    </div>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;">PRODUCTO</th>
                                <th style="text-align:center;">CODIGO</th>
                                <th style="text-align:center;">COSTO</th>
                                <th style="text-align:center;">VENTA</th>
                                <th style="text-align:center;">EXISTENCIA</th>
                                <th style="text-align:center;">SUCURSAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                    foreach ($productos as $key) {
                        $html .= '
                            <tr>
                                <td style="text-align:center;">'.$key->nombre.'</td>
                                <td style="text-align:center;">'.$key->codigo.'</td>
                                <td style="text-align:center;">$'.$key->costo.'</td>
                                <td style="text-align:center;">'.$key->precio.'</td>
                                <td style="text-align:center;">'.$key->stock.'</td>
                                <td style="text-align:center;">'.$key->sucursal.'</td>
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
    public function servicios($servicio_id){
        $servicio = Servicio::find($servicio_id);
        $venta    = Sale::find($servicio->venta_id)->total;
        $total = $venta + $servicio->precio_mano_obre;
        $pdf  = \App::make('dompdf.wrapper');
        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Servicios</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                <style>
                    .card  p{
                        border: 1px solid rgba(0,0,0,0.4);
                        padding:5px;
                        font-size:13px;
                    }
                    .form-group{
                        margin-bottom:1px !important;
                    }
                    .form-group label{
                        font-size:13px;
                        font-weight:bold;
                    }
                    
                </style>
            </head>
            <body>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                          <div id="logo" class="text-center">
                            <img style=" height: 50px; width: 50px;" src="http://italika.mx/WebVisorArchivosITK/Archivo.aspx?Tipo=3&Archivo=WebPortalMexicoITK/img/Italika/italika_logo.png" alt="..."/>
                          </div>
                           
                            <div class="card">

                                <div class="card-body">
                                    <span id="folio">FOLIO: '.$servicio->id.' - FECHA: '.Carbon::now()->format('Y-m-d').'</span>
                                    <div class="form-group">
                                        <label for="">Nombre del cliente</label> 
                                        <p>'.$servicio->nombre_cliente.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                         <p>'.$servicio->direccion.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Teléfono</label>
                                       <p>'.$servicio->telefono.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Modelo de la italika</label>
                                        <p>'.$servicio->modelo_italika.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Numero de serie</label>
                                        <p>'.$servicio->numero_serie.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Cuenta con garantía activa</label>
                                         <p>'.$servicio->garantia.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kilometraje</label>
                                        <p>'.$servicio->kilometraje.'</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Orden del servicio</label>
                                         <p>'.$servicio->orden_servicio.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tipo de servicios</label>
                                         <p>'.$servicio->tipo_servicio.'</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Comentarios del cliente</label>
                                         <p>'.$servicio->comentarios.'</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Sin daños</label>
                                         <p>'.$servicio->sin_danios.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Sin odómetro</label>
                                        <p>'.$servicio->sin_odometraje.'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Precio de mano de obra</label>
                                         <p>$'.number_format($servicio->precio_mano_obre,2,'.',',').'</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Precio consumibles - Refacciones</label>
                                         <p>$'.number_format($venta,2,'.',',').'</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Total servicio</label>
                                         <p>Total: $'.number_format($total,2,'.',',').'</p>
                                    </div>

                                    

                                    <div class="form-group">
                                        <label for="">Telefono del CESIT</label>
                                         <p>'.$servicio->telefono_cecit.'</p>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </body>
            </html>
        ';
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    public function serviciosDia(Request $request){
        $sum_mano_obra = DB::select('call  reporte_servicios_between(?,?)',array($request->inicio,$request->final));
        $servicios     = DB::select('call get_servicios_between(?,?)',array($request->inicio,$request->final));
        //return $servicios;
        $fecha         = Carbon::now()->format('Y-m-d');
        $pdf = \App::make('dompdf.wrapper');
        $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Reporte de servicios</title>
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
                  
                  width:100%;
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
                    <h1>Reporte realizado: '.$fecha.'</h1>
                    <div id="company" class="clearfix">
                        <div>Company Name</div>
                        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
                        <div>(602) 519-0450</div>
                        <div><a href="mailto:company@example.com">company@example.com</a></div>
                    </div>
                    <div id="project">
                        <div><span>REPORTE</span> REPORTE DE SERVICIOS DE '.$request->inicio.' a '.$request->final.'</div>
                        <div><span>USUARIO</span> '.Auth::user()->name.'</div>
                        <div><span>SUCURSAL</span> '.Auth::user()->bussine->nombre.'</div>
                        <div><span>FECHA</span> '.$fecha.'</div>
                        <div><span>TOTAL: </span> '.number_format($sum_mano_obra[0]->mano_obra,2,'.',',').'</div>
                        
                    </div>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;">FECHA</th>
                                <th style="text-align:center;">CLIENTE</th>
                                <th style="text-align:center;">VENTA TOTAL</th>
                                <th style="text-align:center;">MANO DE OBRA</th>
                                <th style="text-align:center;">SERVICIO TOTAL</th>
                                <th style="text-align:center;">VENDEDOR</th>
                                <th style="text-align:center;">SUCURSAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                    foreach ($servicios as $key) {
                        $html .= '
                            <tr>
                                <td style="text-align:center; style="font-size:3px !important;">'.$key->date.'</td>
                                <td style="text-align:center;" style="font-size:3px !important;">'.$key->cliente.'</td>
                                <td style="text-align:center;">$'.number_format($key->venta_total,2,'.',',').'</td>
                                <td style="text-align:center;">$'.number_format($key->mano_obra,2,'.',',').'</td>
                                <td style="text-align:center;">$'.number_format($key->servicio_total,2,'.',',').'</td>
                                <td style="text-align:center; style="font-size:3px !important;">'.$key->vendedor.'</td>
                                <td style="text-align:center; style="font-size:3px !important;">'.$key->sucursal.'</td>
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

}
