<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateregistrosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id');
            $table->integer('habitacione_id');
            $table->string('estado');
            $table->datetime('fecha_ingreso');
            $table->datetime('fecha_salida');
            $table->text('observacion');
            $table->decimal('precio');
            $table->decimal('monto_total');
            $table->integer('user_id');
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
        Schema::drop('registros');
    }
}
