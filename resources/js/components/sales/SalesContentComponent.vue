<template>
    <div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-warning text-center">

                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p class="employer">{{authname}}</p>
                                        <p class="bussine">{{authrol}}</p>
                                        <p class="rol">{{authbussine}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="ti-user"></i> Datos del vendedor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="icon-big icon-success text-center">

                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="numbers">
                                        <p>Agregar por codigo</p>
                                        <input type="text" v-model="code" v-on:keyup="keyProductAddCode" class="form-control" autofocus placeholder="Codigo de barras">
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="fa fa-cog"></i> Consular Inventario | Ventas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                             <input v-model="search" type="text" class="form-control" v-on:keyup="searchProductOnSale" placeholder="Buscar Productos del inventario">  <br>
                            <a  v-if="searchButton != false "  v-on:click="inventario='';" class="btn btn-succes">Limpiar</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                           <h4 class="title">Consultar inventario</h4>
                        </div>
                        <div class="content" style="height:200px; overflow-y:scroll;">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Prod</th>
                                            <th>Cod</th>
                                            <th>$</th>
                                            <th>Can</th>
                                            <th>Acc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in inventario">
                                            <td>{{item.producto}}</td>
                                            <td>{{item.codigo}}</td>
                                            <td>${{item.venta}}</td>
                                            <td>
                                                <input type="number" placeholder="Agregar Cantidad" v-bind:id="'cantidad-'+item.id" class="form-control" >
                                            </td>
                                            <td>
                                                <button class="btn btn-success  btn-sm">Agregar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table-bordered table" >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Pro</th>
                                            <th class="text-center">$</th>
                                            <th class="text-center">Can</th>
                                            <th class="text-center">Sub</th>
                                            <th class="text-center">Acc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <tr v-for="product in products">
                                        <td class="text-center">{{product.id}}</td>

                                        <td class="text-center">{{product.producto}}</td>
                                        <td class="text-center">${{product.price}}</td>
                                        <td class="text-center">{{product.amount}}</td>
                                        <td class="text-center">${{product.subtotal}}</td>
                                        <td class="text-center">
                                            <a v-on:click="onDeleteProductOnSale(product.id);" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                                <i class="ti-calendar"></i> Obtener Reporte
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="icon-big icon-success text-center">
                            <p class="strong-sale">Detalle de la venta</p> <hr>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <sales-compontent-detail v-bind:total="total" v-bind:subtotal="subtotal" v-bind:discount="discount" v-bind:pay="pay"></sales-compontent-detail>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <a v-on:click="endOrder();" style="cursor:pointer;"><i class="ti-calendar"></i> Terminar venta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
const axios = require('axios');
export default {
    data(){
        return{
            //server:"http://www.ital2201.com/",
            server:"http://localhost:8000/",
            code:'',
            search:'',
            products:[],
            inventario:[],
            totalProducts:'',
            searchButton:false,
            total:'',
            subtotal:'',
            pay:'',
            discount:''
        }
    },
    props:['authname','authrol','authbussine','user_id'],
    created(){
        this.getProducts();
        this.getTotal();
    },
    methods:{
        getProducts(){
            this.searchButton = false;
            let route = this.server+'dashboard/orden/productos';
            axios.get(route,{
                headers:{
                    'Access-Control-Allow-Origin': '*',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            }).then((data)=>{
               this.products = data.data;
            }).catch((error)=>{
                alert(error)
            });
        },
        keyProductAddCode(ev){
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if(keycode == '13'){
                ev.preventDefault();
                if(this.code != '')
                    this.storeProductOnOrder();
                this.clearCode();
            }
        },
        searchProductOnSale(ev){
           var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if(keycode == '13'){
                ev.preventDefault();
                if(this.search != '')
                    this.searhProductOnSale();
                this.clearCode();
            } 
        },
        searhProductOnSale(){
            this.searchButton = true;
            let route = this.server+'dashboard/orden/products?search='+this.search;
            axios.get(route,{
                headers:{
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            }).then((responses)=>{
                this.inventario = responses.data;
            });
        },
        storeProductOnOrder(){
            let route = this.server+'dashboard/orden/agregar/producto';
            axios.post(route,{code:this.code}
            ).then((response)=>{
                this.getProducts();
                this.getTotal();
            }).catch((error)=>{
                console.log(error)
            });
        },
        onDeleteProductOnSale(product_id){
            swal({
                title: "Estas seguro?",
                text: "Estas seguro de eliminar el producto de la venta!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    let route = this.server+'dashboard/productos_orden/delete';
                }
            });
            
        }, 
        getTotal(){
            let route = this.server+'dashboard/orden/total';
            axios.get(route,{
                headers:{
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            }).then((responses)=>{
                this.subtotal = responses.data.subtotal;
                this.pay      = responses.data.pay;
                this.discount = responses.data.discount;
                this.total    = responses.data.total; 
            });
        },
        clearCode(){
            this.code = '';
        },
        endOrder(){
            swal({
                title: "Terminar venta",
                text: "Total: $"+this.total,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Venta finalizada correctamente.", {
                        icon: "success",
                    }).then((res)=>{
                        let route = this.server+'dashboard/venta';
                        axios.post(route,{
                            headers:{
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).then((response)=>{
                            location.href = this.server+'dashboard/venta?ticket='+response.data;
                        });
                    });
                }
            });
        }

    }
}
</script>
