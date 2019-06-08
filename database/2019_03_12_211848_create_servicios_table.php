<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_cliente',100);
            $table->longText('direccion',100);
            $table->string('telefono',20);
            $table->string('numero_serie',100);

            $table->integer('orden_servicio');

            $table->string('tipo_servicio');

            $table->longText('comentarios');

            $table->string('sin_danios',10);
            $table->string('sin_odometraje',10);

            $table->double('precio_mano_obre');
            $table->double('precio_consumiblre');
            $table->double('precio_refacciones');
            $table->double('total');

            $table->date('fecha_entrega');

            $table->string('telefono_cecit',20);

            $table->integer('venta_id')->unsigned();

            $table->foreign('venta_id')->references('id')->on('ventas');


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
        Schema::dropIfExists('servicios');
    }
}
