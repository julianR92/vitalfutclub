<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_sede', 100)->comment('Nombre de la sede')->nullable(false);
            $table->string('direccion', 150)->comment('Dirección de la sede')->nullable(false);
            $table->string('telefono', 20)->comment('Teléfono')->nullable(false);
            $table->string('persona_cargo', 100)->comment('Nombre de la persona a cargod de la sede')->nullable(false);

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
        Schema::dropIfExists('sedes');
    }
}
