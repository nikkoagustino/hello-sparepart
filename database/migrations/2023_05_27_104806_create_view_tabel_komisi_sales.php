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
            CREATE VIEW view_tabel_komisi_sales AS 
            SELECT inv.sales_code,
                pym.invoice_no,
                inv.invoice_date,
                pym.payment_date,
                cust.customer_name,
                pym.paid_amount
            FROM tb_penjualan_invoice_bayar AS pym 
            LEFT JOIN tb_penjualan_invoice_master AS inv
                ON pym.invoice_no = inv.invoice_no
            LEFT JOIN tb_customer AS cust
                ON inv.customer_code = cust.customer_code
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_tabel_komisi_sales");
    }
};
