<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function (Blueprint $table) {

            $table->integer('cliente_id')->nullable()->change();
            $table->integer('habitacione_id')->nullable()->change();
            $table->string('estado')->nullable()->change();
            $table->datetime('fecha_ingreso')->nullable()->change();
            $table->datetime('fecha_salida')->nullable()->change();
            $table->text('observacion')->nullable()->change();
            $table->decimal('precio')->nullable()->change();
            $table->decimal('monto_total')->nullable()->change();
            $table->integer('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registros', function (Blueprint $table) {
            //
        });
    }
}
