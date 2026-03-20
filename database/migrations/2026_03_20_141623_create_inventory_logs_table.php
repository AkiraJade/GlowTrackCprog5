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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // User who made the change
            $table->string('reference_type')->nullable(); // Order, Manual, Restock
            $table->unsignedBigInteger('reference_id')->nullable(); // Link to Order ID if applicable
            $table->integer('previous_stock');
            $table->integer('quantity_change');
            $table->integer('new_stock');
            $table->string('reason')->nullable(); // 'damaged', 'expired', 'correction', 'sale', 'return'
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
