<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBussinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bussines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('calle',100);
            $table->string('colonia',100);
            $table->string('estado',100);
            $table->string('ciudad',100);
            $table->string('pais',100);
            $table->integer('numero_exterior');
            $table->integer('numero_interior')->default(0);
            $table->double('caja');
            $table->double('tarjeta');
            $table->double('comision_taller');
            $table->string('estatus')->default('activo');
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
        Schema::dropIfExists('bussines');
    }
}
