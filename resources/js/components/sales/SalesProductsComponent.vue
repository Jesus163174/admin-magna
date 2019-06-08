<template>
    <div>
        
    </div>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    props:{
        product:{
           type: Object
       }
    },
    created(){
        console.log(this.product)
    }
}
</script>
