<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateflujosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flujos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('ingreso',8,2);
            $table->decimal('salida',8,2);
            $table->string('detalle',250);
            $table->text('observacion');
            $table->integer('flujo_id')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::drop('flujos');
    }
}
