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

        DB::statement("
            CREATE VIEW view_invoice_pembelian_rekap_payment AS 
            SELECT inb.invoice_no, 
                SUM(inb.paid_amount) AS total_paid_amount, 
                MAX(inb.payment_date) AS last_payment_date 
            FROM tb_pembelian_invoice_bayar AS inb 
            GROUP BY inb.invoice_no
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_invoice_pembelian_rekap_payment");
    }
};
