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
        Schema::create('tb_penjualan_invoice_master', function (Blueprint $table) {
            $table->string('invoice_no')->primary();
            $table->string('customer_code');
            $table->string('sales_code');
            $table->date('invoice_date');
            $table->unsignedInteger('days_expire')->default(0);
            $table->date('expiry_date')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('invoice_status')->nullable();
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
        Schema::create('tb_penjualan_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('product_code');
            $table->unsignedInteger('normal_price')->default(0);
            $table->float('discount_rate')->default(0);
            $table->unsignedInteger('discounted_price')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('subtotal_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penjualan_invoice_master');
        Schema::dropIfExists('tb_penjualan_invoice_items');
    }
};
