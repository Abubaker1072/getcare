<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_bank_name')->nullable()->after('exchange_rate');
            $table->string('customer_account_number')->nullable()->after('customer_bank_name');
            $table->string('customer_account_holder')->nullable()->after('customer_account_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_bank_name', 'customer_account_number', 'customer_account_holder']);
        });
    }
};
