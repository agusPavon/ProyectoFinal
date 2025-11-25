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
    Schema::create('checkins', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('cafe_id')->nullable()->constrained()->onDelete('set null');

        $table->string('image')->nullable();
        $table->string('comment', 180)->nullable(); // Texto breve
        $table->decimal('lat', 10, 7)->nullable();
        $table->decimal('lng', 10, 7)->nullable();
        $table->integer('points_awarded')->default(10);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
