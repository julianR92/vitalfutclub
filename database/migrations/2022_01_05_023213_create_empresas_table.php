<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();

            $table->string('nit', 20)->comment('Nit de la empresa')->nullable(false);
            $table->string('razon_social',100)->comment('Nombre de la empresa')->nullable(false);
            $table->string('direccion',150)->comment('Dirección de la empresa')->nullable(false);
            $table->string('representante',50)->comment('Representante legal')->nullable(false);
            $table->string('telefono',50)->comment('teléfono')->nullable(false);
            $table->string('correo',50)->comment('Correo electrónico')->nullable(false);

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
        Schema::dropIfExists('empresa');
    }
}
