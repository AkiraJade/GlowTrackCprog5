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
        Schema::create('routine_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('routine_id')->constrained('skincare_routines')->onDelete('cascade');
            $table->enum('step_type', ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'SPF', 'Other']);
            $table->string('product_name')->nullable(); // Can be custom product
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('step_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_steps');
    }
};
