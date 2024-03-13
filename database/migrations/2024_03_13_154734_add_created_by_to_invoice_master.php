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
        Schema::table('tb_pembelian_invoice_master', function (Blueprint $table) {
            $table->string('created_by')->nullable()->after('invoice_status');
        });
        Schema::table('tb_penjualan_invoice_master', function (Blueprint $table) {
            $table->string('created_by')->nullable()->after('invoice_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_pembelian_invoice_master', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('tb_penjualan_invoice_master', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
};
