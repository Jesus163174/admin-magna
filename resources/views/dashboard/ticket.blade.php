<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }
        td,th,tr,table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }
        td.producto,th.producto {
            width: 150px;
            max-width: 150px;
        }
        td.cantidad,th.cantidad {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        td.precio,th.precio {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        .centrado {
            text-align: center;
            align-content: center;
            width: 100%;
        }
        .ticket {
            width: 155px;
            max-width: 155px;
        }
        img {
            max-width: inherit;
            width: inherit;
        }
        @media print{
          .oculto-impresion, .oculto-impresion *{
            display: none !important;
          }
        }
    </style>
</head>
<body>
<div class="ticket">
    <img src="https://scontent.ftgz1-1.fna.fbcdn.net/v/t1.0-9/55547007_673429456404743_8159167067476459520_n.jpg?_nc_cat=110&_nc_eui2=AeEobwTS0yHofdS0Uxb_1cUdzYtf1h9ybab3GbUTnKKIKU19uzqNrSkkoMMANR1p91swMz7X_weYxt_NZrW8915gX57JNkeljJfMbMAian0ybQ&_nc_ht=scontent.ftgz1-1.fna&oh=aa7e31e4834f8001ea651e0cca2f6a67&oe=5D3D85D1" alt="Logotipo">
    <p class="centrado">
        Sucursal {{$bussine->nombre}} <br> 
        Calle {{$bussine->calle}} numero {{$bussine->numero_exterior}},Colonia {{$bussine->colonia}}, <br>
        Atendido por: {{$user->name}}, Venta:{{$sale->status}} <br>
        Fecha: {{$sale->created_at}} <br>
        Folio: {{$sale->id}}
    </p>
    <section id="ticket" style="display: flex; justify-content: space-between; align-items: center;">
        <div id="pro-th">CANT</div>
        <div id="pre-th">PRO  <br></div>   
        <div id="cod-th">P/U</div>
        <div id="subtotal">IMP</div>
    </section>
    <hr>
    @foreach($products as $product)
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div id="pro-td">
                {{$product->cantidad}} 
            </div>
            <div id="pre-td" style="text-align: center;">{{$product->producto}} </div>
            <div id="can-td" style="text-align: center; margin-right:3px !important;">${{$product->precio}} </div>
            <div id="subtotal" style="text-align: center;">${{$product->subtotal}} </div>
        </div>
        <hr>
    @endforeach
    <div id="total"> <br>
        Pago con tarjeta : $0.00 <br>
        Descuento: $0.00 <br>
        ============ <br>
        Subtotal: ${{number_format($total,2,'.',',')}}  
        ============ <br>
        Total: ${{number_format($subtotal,2,'.',',')}} <br>
        ============ <br>
    </div>
    <p class="centrado">RFC: CAC130624MY3</p>
    <p class="centrado">Email: motocrea@hotmail.com</p>
    <p class="centrado">¡GRACIAS POR SU COMPRA!</p>
    <p class="centrado">Este ticket no es comprobante fiscal y se incluirá en la venta del día</p>
</div>
<a href="{{asset('dashboard/vender')}}" class="oculto-impresion">Regresar</a>
</body>
<script>
    window.print();
    window.addEventListener("afterprint", function(event) {
       location.href ="http://localhost:8000/dashboard/vender";
    });
</script>
</html>