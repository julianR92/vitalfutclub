<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerPlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_planes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('persona_id')->comment('Llave foranea de la tabla persona')->unsigned();
            $table->bigInteger('plan_id')->comment('Llave foranea de la tabla planes')->unsigned();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->smallInteger('numero_clase');
            $table->smallInteger('cantidad_plan');
            $table->boolean('estado');
            $table->string('observacion',255)->nullable();

            $table->timestamps();
        });

        Schema::table('per_planes', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('planes');
            $table->index('plan_id');
        });

        Schema::table('per_planes', function (Blueprint $table) {
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->index('persona_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_planes');
    }
}
