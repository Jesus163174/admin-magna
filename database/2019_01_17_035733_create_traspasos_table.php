<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraspasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('envia')->unsigned();
            $table->integer('recibe')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->string('estatus')->default('enviado');
            $table->string('razon',100);

            $table->foreign('envia')->references('id')->on('bussines');
            $table->foreign('recibe')->references('id')->on('bussines');
            $table->foreign('usuario_id')->references('id')->on('users');
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
        
    }
}
