<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateprecioshabitacionesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precioshabitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('habitacione_id');
            $table->decimal('precio', 5, 2);
            $table->string('estado', 15);
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
        Schema::drop('precioshabitaciones');
    }
}
