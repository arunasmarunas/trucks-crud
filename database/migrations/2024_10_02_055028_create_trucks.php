<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing integer
            $table->string('unit_number', 255)->collation('utf8mb4_general_ci')->unique(); // Unique unit number with a maximum length of 255 characters
            $table->year('year'); // Year column for the truck's year
            $table->text('notes')->nullable()->collation('utf8mb4_general_ci'); // Notes column, nullable, text type
            $table->timestamps(); // Created at and Updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
