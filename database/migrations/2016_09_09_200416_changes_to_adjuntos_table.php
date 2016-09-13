<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesToAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjuntos', function (Blueprint $table) {
            //
            $table->dropColumn('dato');
            $table->string('nombre_original',255);
            $table->string('nombre_archivo',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjuntos', function (Blueprint $table) {
            //
        });
    }
}
