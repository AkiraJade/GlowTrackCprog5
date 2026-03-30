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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('brand');
            $table->enum('classification', ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment']);
            $table->decimal('price', 8, 2);
            $table->string('size_volume');
            $table->integer('quantity')->default(0);
            $table->string('photo')->nullable();
            $table->foreignId('seller_id')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected', 'inactive'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->text('skin_types')->nullable();
            $table->text('active_ingredients')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
