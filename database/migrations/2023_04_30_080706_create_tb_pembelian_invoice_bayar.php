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
        Schema::create('tb_pembelian_invoice_bayar', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->unsignedInteger('paid_amount');
            $table->date('payment_date');
            $table->string('payment_proof')->nullable();
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian_invoice_bayar');
    }
};
