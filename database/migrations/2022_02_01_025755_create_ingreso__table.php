<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('per_plan_id')->comment('Llave foranea de la tabla per_plan')->unsigned();
            $table->datetime('fecha_ingreso');
            $table->timestamps();
        });

        Schema::table('ingreso', function (Blueprint $table) {
            $table->foreign('per_plan_id')->references('id')->on('per_planes');
            $table->index('per_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso');
    }
}
