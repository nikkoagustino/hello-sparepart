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
            CREATE VIEW view_invoice_jual_modal AS 
            SELECT inv.invoice_no, 
                inv.invoice_date,
                itm.product_code,
                itm.qty,
                itm.discounted_price AS harga_jual,
                itm.subtotal_price AS subtotal_jual,
                prd.price_capital AS modal_satuan,
                (prd.price_capital * itm.qty) AS subtotal_modal
            FROM tb_penjualan_invoice_items AS itm 
            LEFT JOIN tb_penjualan_invoice_master AS inv
                ON itm.invoice_no = inv.invoice_no
            LEFT JOIN tb_product AS prd
                ON itm.product_code = prd.product_code
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_invoice_jual_modal");
    }
};
