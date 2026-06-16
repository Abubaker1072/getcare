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
        Schema::table('products', function (Blueprint $table) {
            $table->string('tags')->nullable();
            $table->string('promo_text')->nullable();
            $table->json('bullet_points')->nullable();
            $table->json('features')->nullable();
            $table->text('how_to_use')->nullable();
            $table->text('ingredients')->nullable();
            $table->json('faqs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'tags',
                'promo_text',
                'bullet_points',
                'features',
                'how_to_use',
                'ingredients',
                'faqs'
            ]);
        });
    }
};
