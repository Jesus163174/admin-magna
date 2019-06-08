<template>
    <div>
     <div class="content">
        <div class="row">
            <div class="col-md-6">
                <span>Subtotal: </span>
            </div>
            <div class="col-md-6 text-right">${{subtotal}}</div>
        </div><hr>
        <div class="row">
            <div class="col-md-6">
                <span>Descuento: </span>
            </div>
            <div class="col-md-6 text-right">${{discount}}</div>
        </div><hr>
        <div class="row">
            <div class="col-md-6">
                <span>P/Tarjeta: </span>
            </div>
            <div class="col-md-6 text-right">${{pay}}</div>
        </div><hr>
        <div class="row">
            <div class="col-md-6">
                <span class="total strong-sale">Total: </span>
            </div>
            <div class="col-md-6 text-right total-number strong-sale">${{total}}</div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    props:['total','discount','pay','subtotal'],
    created(){
        
    }
}
</script>
