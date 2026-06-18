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
        Schema::table('customer_messages', function (Blueprint $table) {
            $table->string('order_number')->nullable();
            $table->text('address')->nullable();
            $table->string('image_path')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_messages', function (Blueprint $table) {
            $table->dropColumn(['order_number', 'address', 'image_path', 'phone_number', 'reason']);
        });
    }
};
