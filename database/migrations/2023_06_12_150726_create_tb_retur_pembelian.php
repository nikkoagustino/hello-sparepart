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
        Schema::create('tb_retur_pembelian', function (Blueprint $table) {
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
        Schema::dropIfExists('tb_retur_pembelian');
    }
};
