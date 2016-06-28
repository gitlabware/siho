<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateclientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nacionalidad');
            $table->date('edad');
            $table->string('procedencia');
            $table->string('profesion');
            $table->string('pasaporte');
            $table->string('ci');
            $table->string('celular');
            $table->string('referencia');
            $table->string('estado');
            $table->string('direccion');
            $table->text('observaciones');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientes');
    }
}
