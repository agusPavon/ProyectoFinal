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
    // Tabla de badges
    Schema::create('badges', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('icon')->nullable(); // ícono o imagen del badge
        $table->integer('required_beans')->default(0);
        $table->timestamps();
    });

    // Relación usuario-badge
    Schema::create('badge_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('badge_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('badge_user');
    Schema::dropIfExists('badges');
    }
};
