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
        Schema::create('ingredient_conflicts', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient_1');
            $table->string('ingredient_2');
            $table->enum('severity', ['low', 'moderate', 'high', 'severe']);
            $table->text('description');
            $table->text('recommendation');
            $table->text('alternatives')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add indexes for performance
            $table->index(['ingredient_1', 'ingredient_2']);
            $table->index('severity');
            $table->index('is_active');
            
            // Add unique constraint to prevent duplicate conflicts
            $table->unique(['ingredient_1', 'ingredient_2'], 'unique_ingredient_pair');
        });

        Schema::create('routine_conflict_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skincare_routine_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_conflict_id')->constrained()->onDelete('cascade');
            $table->text('conflicting_ingredients');
            $table->boolean('is_acknowledged')->default(false);
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'skincare_routine_id']);
            $table->index('is_acknowledged');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_conflict_warnings');
        Schema::dropIfExists('ingredient_conflicts');
    }
};
