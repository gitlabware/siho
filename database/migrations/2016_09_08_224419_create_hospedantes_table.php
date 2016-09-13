<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospedantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospedantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id');
            $table->integer('registro_id');
            $table->string('estado',50);
            $table->datetime('fecha_ingreso');
            $table->datetime('fecha_salida')->nullable();
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
        Schema::drop('hospedantes');
    }
}
