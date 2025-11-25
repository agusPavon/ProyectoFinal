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
    Schema::create('points_history', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('action'); // review, suggestion, suggestion_approved, etc.
        $table->integer('beans');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('points_history');
    }
};
