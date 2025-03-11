<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_plan', 100)->comment('Nombre del plan')->nullable(false);
            $table->integer('numero_clases')->comment('Número de clases que contiene el plan')->nullable(false);
            $table->integer('numero_dias')->comment('Número de dias')->nullable(false);
            $table->integer('valor')->comment('Valor del plan')->nullable(false);

            $table->bigInteger('sede_id')->comment('Llave foranea de la sede')->nullable(false)->unsigned();
            $table->foreign('sede_id')->references('id')->on('sedes');

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
        Schema::dropIfExists('planes');
    }
}
