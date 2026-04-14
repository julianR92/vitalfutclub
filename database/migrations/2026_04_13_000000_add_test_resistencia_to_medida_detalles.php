<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medida_detalles', function (Blueprint $table) {
            $table->decimal('test_resistencia', 4, 1)->nullable()->after('elasticidad');
        });
    }

    public function down(): void
    {
        Schema::table('medida_detalles', function (Blueprint $table) {
            $table->dropColumn('test_resistencia');
        });
    }
};
