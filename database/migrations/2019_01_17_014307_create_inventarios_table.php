<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('nombre',500);
            $table->string('codigo',200);
            $table->integer('existencia');
            $table->double('costo');
            $table->double('precio_Venta');
            $table->integer('bussine_id')->unsigned();
            $table->string('foto');
            $table->integer('categoria_id')->unsigned();
            $table->string('estatus')->default('activo');
            $table->double('iva');
            $table->string('clave_unidad');
            $table->string('clave_producto');
            $table->integer('color_id')->unsigned();
            $table->integer('marca_id')->unsigned();

            $table->foreign('color_id')->references('id')->on('colors');

            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('bussine_id')->references('id')->on('bussines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}
