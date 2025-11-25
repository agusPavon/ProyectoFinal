<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('cafes', function (Blueprint $table) {
        $table->string('roasting_type')->nullable();   // tipo de tostado
        $table->string('origin')->nullable();          // origen del café
        $table->string('milk')->nullable();            // leche alternativa
        $table->json('attributes')->nullable();        // características
        $table->string('image')->nullable();           // foto destacada
    });
}

public function down()
{
    Schema::table('cafes', function (Blueprint $table) {
        $table->dropColumn([
            'roasting_type',
            'origin',
            'milk',
            'attributes',
            'image'
        ]);
    });
}

};
