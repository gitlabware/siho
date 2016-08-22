<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatefacturasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_control');
            $table->string('cliente');
            $table->string('nit');
            $table->string('nit_p');
            $table->decimal('importetotal');
            $table->date('fecha');
            $table->date('fecha_limite');
            $table->integer('numero');
            $table->integer('autorizacion');
            $table->text('qr');
            $table->text('montoliteral');
            $table->datetime('created');
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
        Schema::drop('facturas');
    }
}
