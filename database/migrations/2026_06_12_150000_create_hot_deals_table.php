<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create hot_deals table
        Schema::create('hot_deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
        });

        // 2. Migrate existing data if old table exists
        if (Schema::hasTable('homepage_hot_deal_products')) {
            $records = DB::table('homepage_hot_deal_products')->get();
            foreach ($records as $record) {
                DB::table('hot_deals')->insert([
                    'id' => $record->id,
                    'product_id' => $record->product_id,
                    'created_at' => $record->created_at,
                    'updated_at' => $record->updated_at,
                ]);
            }

            // 3. Drop old table
            Schema::dropIfExists('homepage_hot_deal_products');
        }
    }

    public function down(): void
    {
        // Recreate the old table
        Schema::create('homepage_hot_deal_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
        });

        // Restore data from hot_deals to homepage_hot_deal_products
        if (Schema::hasTable('hot_deals')) {
            $records = DB::table('hot_deals')->get();
            foreach ($records as $record) {
                DB::table('homepage_hot_deal_products')->insert([
                    'id' => $record->id,
                    'product_id' => $record->product_id,
                    'created_at' => $record->created_at,
                    'updated_at' => $record->updated_at,
                ]);
            }
        }

        // Drop the new table
        Schema::dropIfExists('hot_deals');
    }
};
