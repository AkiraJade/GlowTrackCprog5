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
        Schema::create('routine_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skincare_routine_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->string('skin_type')->nullable(); // Oily, Dry, Combination, Sensitive, Normal
            $table->text('results_observed')->nullable();
            $table->timestamps();
            
            // Ensure a user can only review a routine once
            $table->unique(['user_id', 'skincare_routine_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_reviews');
    }
};
