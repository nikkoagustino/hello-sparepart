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
        DB::statement('SET sql_mode=""');
        DB::statement("
            CREATE VIEW view_labarugi_product AS
            SELECT inv.invoice_no, itm.product_code, inv.invoice_date, prd.type_code, 
                itm.qty AS qty_sold, 
                COALESCE(ret.qty, 0) AS qty_retur,
                ((itm.qty - COALESCE(ret.qty, 0)) * prd.price_capital) AS total_modal, 
                ((itm.qty - COALESCE(ret.qty, 0)) * itm.discounted_price) AS total_penjualan, 
                ((itm.qty - COALESCE(ret.qty, 0)) * (itm.discounted_price - prd.price_capital)) AS total_laba
            FROM tb_penjualan_invoice_items AS itm
            LEFT JOIN tb_penjualan_invoice_master AS inv
                ON itm.invoice_no = inv.invoice_no
            LEFT JOIN tb_product AS prd
                ON itm.product_code = prd.product_code
            LEFT JOIN tb_product_type AS typ
                ON prd.type_code = typ.type_code
            LEFT JOIN tb_retur_penjualan AS ret
                ON itm.product_code = ret.product_code AND itm.invoice_no = ret.invoice_no;
            ;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_labarugi_product");
    }
};
