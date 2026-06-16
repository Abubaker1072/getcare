<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('rating');
            $table->string('title');
            $table->text('text');
            $table->string('product_name')->nullable();
            $table->boolean('is_approved')->default(true); // Default to approved so it displays automatically, but admin can reject or toggle
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
