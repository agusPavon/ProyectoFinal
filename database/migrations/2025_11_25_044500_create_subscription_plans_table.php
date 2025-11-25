<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price'); // en ARS o cents, como quieras
            $table->string('description')->nullable();
            $table->string('coffee_bag_size')->nullable(); // ej: "250g"
            $table->integer('deliveries_per_month')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};