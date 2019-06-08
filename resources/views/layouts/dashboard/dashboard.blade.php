<!doctype html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="https://image.flaticon.com/icons/svg/1069/1069102.svg"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('assets/css/paper-dashboard.css')}}" rel="stylesheet"/>
        <link href="{{asset('assets/css/demo.css')}}" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link href="{{asset('assets/css/themify-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
        <style>
            ul.nav>li.active > a{
                color:#243882 !important;
            }
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none; 
            }
        </style>
        @yield('css')
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar" data-background-color="white" data-active-color="danger">
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="{{asset('/')}}" class="simple-text">
                        
                        MAGNA SISTEMA
                        </a>
                    </div>
                    <ul class="nav">
                        @if(Auth::user()->rol == 'administrador')
                        <li @if(Request::is('/')) class="active" @endif>
                        <a href="{{asset('/')}}">
                            <i class="ti-home"></i>
                            <p>INICIO</p>
                        </a>
                        </li>
                        @endif
                        <li @if(Request::is('vender')) class="active" @endif>
                        <a href="{{asset('/vender')}}">
                            <i class="ti-shopping-cart"></i>
                            <p>VENDER</p>
                        </a>
                        </li>
                        
                        <li @if(Request::is(Auth::user()->rol.'/ventas')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/ventas')}}">
                            <i class="ti-money"></i>
                            <p>VENTAS</p>
                        </a>
                        </li>
                        <li>
                            <a href="{{asset(Auth::user()->rol.'/ventas')}}">
                                <i class="ti-view-list-alt"></i>
                                <p>FACTURACIÓN</p>
                            </a>
                        </li>
                        <li @if(Request::is(Auth::user()->rol.'/productos')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/productos')}}">
                            <i class="ti-bag"></i>
                            <p>INVENTARIO</p>
                        </a>
                        </li>
                        <li @if(Request::is('reportes')) class="active" @endif>
                            <a href="{{asset('reportes')}}">
                                <i class="ti-file"></i>
                                <p>REPORTES</p>
                            </a>
                        </li>
                       
                        <li>
                            <a href="{{asset(Auth::user()->rol.'/gastos')}}">
                                <i class="ti-share"></i>
                                <p>GASTOS</p>
                            </a>
                        </li>
                        @if(Auth::user()->rol == 'administrador')
                        <li @if(Request::is(Auth::user()->rol.'/sucursales')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/sucursales')}}">
                            <i class="ti-home"></i>
                            <p>SUCURSALES</p>
                        </a>
                        </li>
                        @endif
                        @if(Auth::user()->rol == 'administrador')
                            <li @if(Request::is(Auth::user()->rol.'/usuarios')) class="active" @endif> 
                            <a href="{{asset(Auth::user()->rol.'/usuarios')}}">
                                <i class="ti-user"></i>
                                <p>EMPLEADOS</p>
                            </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{asset('dashboard/v/admin/traspasos')}}">
                                <i class="ti-share"></i>
                                <p>
                                TRASPASOS
                                @if(Auth::user()->rol != 'administrador')
                                    ({{count($services_traspaso)}})
                                @endif</p>
                            </a>
                        </li>
                        <li>
                            <a href="/">
                                <i class="ti-share-alt"></i>
                                <p>DEVOLUCIONES</p>
                            </a>
                        </li>
                        @if(Auth::user()->rol == 'administrador')
                        <li @if(Request::is(Auth::user()->rol.'/marcas')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/marcas')}}">
                            <i class="ti-rss"></i>
                            <p>MARCAS</p>
                        </a>
                        </li>
                        <li @if(Request::is(Auth::user()->rol.'/marcas')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/colores')}}">
                            <i class="ti-rss"></i>
                            <p>COLORES</p>
                        </a>
                        </li>
                        @endif
                        @if(Auth::user()->rol == 'administrador')
                        <li @if(Request::is(Auth::user()->rol.'/categorias')) class="active" @endif>
                        <a href="{{asset(Auth::user()->rol.'/categorias')}}">
                            <i class="ti-rss"></i>
                            <p>CATEGORIAS</p>
                        </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                            </button>
                            <a data-toggle="modal" class="btn btn-info btn-block btn-lg" data-target=".bs-example-modal-lg-global" style="width: 400px; !important;"> 
                            <i class="ti-search"></i>Consultar inventario global</a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a >
                                        <p></p>
                                    </a>
                                <li>
                                    <a href="{{asset('vender')}}">
                                        <i class="ti-shopping-cart"></i>
                                        <p>Vender</p>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class=" ti-user"></i>
                                        <p>Perfil</p>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a>
                                            <i class="ti-user"></i> {{Auth::user()->name}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                            <i class="ti-home"></i> Sucursal {{Auth::user()->bussine->nombre}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                            <i class=" ti-lock"></i> {{strtoupper(Auth::user()->rol)}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{asset(Auth::user()->rol.'/perfil?id='.Auth::user()->id)}}">
                                            <i class="ti-files"></i> Editar datos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="ti-share"></i>
                                        <p>
                                            Traspasos
                                            ({{count($services_traspaso)}})
                                        </p>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @if(Auth::user()->rol == 'administrador')
                                            @include('layouts.dashboard.notificacion_admin')
                                        @else
                                            @include('layouts.dashboard.notificacion_vendedor')
                                        @endif
                                    </ul>
                                </li>
                                <li>
                                    <a  href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class=" ti-lock"></i>
                                        <p>Salir</p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="pull-left">
                            <ul>
                            </ul>
                        </nav>
                        <div class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script>, Inusual Admin V1.0 
                            <img src="{{asset('svg/alien.jpg')}}" width="20" height="20" alt=""> Por <a target="_blanck" href="http://inusualsoft.com/">Inusual Software</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title">Inventario {{Auth::user()->bussine->nombre}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="content table-responsive ">
                            <table id="data" class="table table-striped">
                                <thead>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Precio</th>
                                    <th class="text-center">
                                        Cantidad
                                    </th>
                                    <th class="text-center">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($products_bussine as $product)
                                    <tr>
                                        <td class="text-center">
                                           {{$product->nombre}}
                                        </td>
                                        <td class="text-center">{{$product->codigo}}</td>
                                        <td class="text-center">
                                            @if($product->stock >5)
                                                <span class="label label-success">{{$product->stock}}</span>
                                            @else
                                                <span class="label label-danger">{{$product->stock}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">${{number_format($product->precio,2,'.',',')}}</td>
                                        <form action="{{asset('dashboard/orden/producto/inventario')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <td class="text-center">
                                                <input type="number" max="{{$product->stock}}" @if($product->stock == 0) disabled=""  @endif class="form-control" name="cantidad" value="1">
                                            </td>
                                            <td class="text-center">
                                                @if($product->stock >0)
                                                <button class="btn btn-success btn-sm">Agregar producto</button>
                                                @else
                                                <a class="btn btn-danger btn-sm">No hay en existencia</a>
                                                @endif
                                            </td>
                                        </form>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="{{asset('assets/js/bootstrap-checkbox-radio.js')}}"></script>
    <!--  Charts Plugin -->
    <script src="{{asset('assets/js/chartist.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{asset('assets/js/bootstrap-notify.js')}}"></script>
    <!--  Google Maps Plugin    -->
    
    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="{{asset('assets/js/paper-dashboard.js')}}"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{asset('assets/js/demo.js')}}"></script>
    <script src="{{asset('js/data-table.js')}}"></script>
    <script src="{{asset('js/data-boot.js')}}"></script>
    <script src="{{asset('js/init-table.js')}}"></script>
    <script
        src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.flash.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script
        src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script
        src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.print.min.js"></script>
    @yield('js')
</html>

