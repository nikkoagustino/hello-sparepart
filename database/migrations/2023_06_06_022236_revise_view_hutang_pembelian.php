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
        DB::statement("DROP VIEW IF EXISTS view_hutang_pembelian");
        DB::statement("
            CREATE VIEW view_hutang_pembelian AS 
            SELECT inv.invoice_no, 
                inv.total_price,
                IFNULL(pym.total_paid_amount,0) AS total_paid_amount,
                inv.total_price - IFNULL(pym.total_paid_amount,0) AS hutang
            FROM view_invoice_pembelian_detail AS inv 
            LEFT JOIN view_invoice_pembelian_rekap_payment AS pym
                ON inv.invoice_no = pym.invoice_no
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_hutang_pembelian");
    }
};
