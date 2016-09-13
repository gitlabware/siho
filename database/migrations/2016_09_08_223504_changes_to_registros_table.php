<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesToRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function (Blueprint $table) {
            //
            $table->dropColumn('num_reg');
            $table->dropColumn('monto_total');
            $table->dropColumn('flujo_id');
            $table->integer('grupo_id')->nullable();
            $table->string('equipaje',50);
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
