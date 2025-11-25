<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cafe_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('website')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('roasting_type')->nullable();
            $table->json('attributes')->nullable();
            $table->string('status')->default('pendiente'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cafe_suggestions');
    }
};

