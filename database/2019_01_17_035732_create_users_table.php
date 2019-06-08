<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('celular');
            $table->string('email');
            $table->string('password');
            $table->string('rol');
            $table->integer('bussine_id')->unsigned();
            $table->string('status')->default('activo');
            $table->double('comision_mostrador')->default(0);
            $table->foreign('bussine_id')->references('id')->on('bussines');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
