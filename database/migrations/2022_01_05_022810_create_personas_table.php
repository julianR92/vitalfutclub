<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_doc', 30)->comment('Tipo de documento')->nullable();
            $table->string('documento', 20)->comment('Número de documento')->unique();
            $table->string('nombres', 25)->comment('Nombres')->nullable();
            $table->string('apellidos', 25)->comment('Apellidos')->nullable();
            $table->string('direccion', 150)->comment('Dirección residencia')->nullable(false);
            $table->string('telefono', 20)->comment('Teléfono')->nullable();
            $table->string('correo', 150)->comment('Correo para notificaciones');

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {

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
        Schema::dropIfExists('personas');
    }
}
