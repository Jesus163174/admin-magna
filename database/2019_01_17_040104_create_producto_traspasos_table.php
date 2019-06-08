<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTraspasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_traspasos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('traspaso_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('cantidad');

            $table->foreign('traspaso_id')->references('id')->on('traspasos');
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
        Schema::dropIfExists('producto_traspasos');
    }
}
