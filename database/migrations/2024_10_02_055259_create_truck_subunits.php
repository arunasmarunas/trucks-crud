<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('truck_subunits', function (Blueprint $table) {
            // Define columns without timestamps
            $table->unsignedBigInteger('main_truck'); // Foreign key referencing the main truck
            $table->unsignedBigInteger('subunit'); // Foreign key referencing the subunit truck
            $table->date('start_date'); // Start date for the subunit
            $table->date('end_date'); // End date for the subunit

            // Set composite primary key
            $table->primary(['main_truck', 'subunit']);

            // Add foreign key constraints
            $table->foreign('main_truck')->references('id')->on('trucks')->onDelete('cascade');
            $table->foreign('subunit')->references('id')->on('trucks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_subunits');
    }
};
