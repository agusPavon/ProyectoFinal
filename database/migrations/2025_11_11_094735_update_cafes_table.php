<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cafes', function (Blueprint $table) {

            // Campos de texto / números
            if (!Schema::hasColumn('cafes', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('cafes', 'average_rating')) {
                $table->float('average_rating')->nullable();
            }

            if (!Schema::hasColumn('cafes', 'website')) {
                $table->string('website')->nullable();
            }

            // Campos JSON
            if (!Schema::hasColumn('cafes', 'opening_hours')) {
                $table->json('opening_hours')->nullable();
            }

            if (!Schema::hasColumn('cafes', 'coffee_types')) {
                $table->json('coffee_types')->nullable();
            }

            if (!Schema::hasColumn('cafes', 'milk_options')) {
                $table->json('milk_options')->nullable();
            }

            if (!Schema::hasColumn('cafes', 'features')) {
                $table->json('features')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cafes', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'average_rating',
                'website',
                'opening_hours',
                'coffee_types',
                'milk_options',
                'features',
            ]);
        });
    }
};
