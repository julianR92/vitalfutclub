<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('per_plan_id')->comment('Llave foranea de la tabla per_planes')->unsigned();
            $table->date('fecha_factura');
            $table->string('ruta_factura',255);
            $table->timestamps();
        });

        Schema::table('factura', function (Blueprint $table) {
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
        Schema::dropIfExists('factura');
    }
}
