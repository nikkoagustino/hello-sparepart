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
        DB::statement("DROP VIEW IF EXISTS view_invoice_penjualan_detail");
        DB::statement('SET sql_mode=""');
        DB::statement("
            CREATE VIEW view_invoice_penjualan_detail AS 
            SELECT inv.*, 
                cust.customer_name,
                cust.address AS customer_address,
                cust.contact_person AS customer_cp,
                cust.phone_number_1 AS customer_phone_1, 
                cust.phone_number_2 AS customer_phone_2, 
                sal.sales_name AS sales_name,
                sal.phone_number_1 AS sales_phone_1,
                sal.phone_number_2 AS sales_phone_2,
                SUM(itm.qty) AS total_qty, 
                SUM(itm.subtotal_price) AS total_invoice_price, 
                COALESCE(SUM(ret.qty), 0) AS total_retur_qty, 
                COALESCE(SUM(ret.subtotal_price), 0) AS total_retur_price, 
                SUM(itm.subtotal_price) - COALESCE(SUM(ret.subtotal_price),0) AS total_price 
            FROM tb_penjualan_invoice_master AS inv 
            LEFT JOIN tb_customer AS cust 
                ON inv.customer_code = cust.customer_code
            LEFT JOIN tb_sales AS sal 
                ON inv.sales_code = sal.sales_code
            LEFT JOIN tb_penjualan_invoice_items AS itm 
                ON inv.invoice_no = itm.invoice_no
            LEFT JOIN tb_retur_penjualan AS ret 
                ON inv.invoice_no = ret.invoice_no AND itm.product_code = ret.product_code
            GROUP BY inv.invoice_no;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_invoice_penjualan_detail");
    }
};
