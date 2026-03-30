<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert MySQL JSON columns to TEXT (values remain serialized; Eloquent array casts unchanged).
     */
    public function up(): void
    {
        if (Schema::hasTable('notifications')) {
            DB::statement('ALTER TABLE notifications MODIFY data TEXT NULL');
        }

        if (Schema::hasTable('skin_profiles')) {
            DB::statement('ALTER TABLE skin_profiles MODIFY skin_concerns TEXT NULL');
            DB::statement('ALTER TABLE skin_profiles MODIFY ingredient_allergies TEXT NULL');
        }

        if (Schema::hasTable('seller_applications')) {
            DB::statement('ALTER TABLE seller_applications MODIFY product_categories TEXT NOT NULL');
        }

        if (Schema::hasTable('ingredient_conflicts')) {
            DB::statement('ALTER TABLE ingredient_conflicts MODIFY alternatives TEXT NULL');
        }

        if (Schema::hasTable('routine_conflict_warnings')) {
            DB::statement('ALTER TABLE routine_conflict_warnings MODIFY conflicting_ingredients TEXT NOT NULL');
        }

        if (Schema::hasTable('products')) {
            if (! Schema::hasColumn('products', 'skin_types')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('skin_types')->nullable()->after('review_count');
                });
            }
            if (! Schema::hasColumn('products', 'active_ingredients')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->text('active_ingredients')->nullable()->after('skin_types');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notifications')) {
            DB::statement('ALTER TABLE notifications MODIFY data JSON NULL');
        }

        if (Schema::hasTable('skin_profiles')) {
            DB::statement('ALTER TABLE skin_profiles MODIFY skin_concerns JSON NULL');
            DB::statement('ALTER TABLE skin_profiles MODIFY ingredient_allergies JSON NULL');
        }

        if (Schema::hasTable('seller_applications')) {
            DB::statement('ALTER TABLE seller_applications MODIFY product_categories JSON NOT NULL');
        }

        if (Schema::hasTable('ingredient_conflicts')) {
            DB::statement('ALTER TABLE ingredient_conflicts MODIFY alternatives JSON NULL');
        }

        if (Schema::hasTable('routine_conflict_warnings')) {
            DB::statement('ALTER TABLE routine_conflict_warnings MODIFY conflicting_ingredients JSON NOT NULL');
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'skin_types')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn(['skin_types', 'active_ingredients']);
            });
        }
    }
};
