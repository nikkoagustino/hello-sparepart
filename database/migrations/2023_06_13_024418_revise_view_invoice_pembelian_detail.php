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
        DB::statement("DROP VIEW IF EXISTS view_invoice_pembelian_detail");
        DB::statement('SET sql_mode=""');
        DB::statement("
            CREATE VIEW view_invoice_pembelian_detail AS 
            SELECT inv.*, 
                sup.supplier_name,
                sup.address AS supplier_address,
                sup.contact_person AS supplier_cp,
                sup.phone_number_1 AS supplier_phone_1, 
                sup.phone_number_2 AS supplier_phone_2, 
                SUM(itm.qty) AS total_qty, 
                SUM(itm.subtotal_price) AS total_invoice_price,
                COALESCE(SUM(ret.qty), 0) AS total_retur_qty, 
                COALESCE(SUM(ret.subtotal_price), 0) AS total_retur_price, 
                SUM(itm.subtotal_price) - COALESCE(SUM(ret.subtotal_price),0) AS total_price 
            FROM tb_pembelian_invoice_master AS inv 
            LEFT JOIN tb_supplier AS sup 
                ON inv.supplier_code = sup.supplier_code
            LEFT JOIN tb_pembelian_invoice_items AS itm 
                ON inv.invoice_no = itm.invoice_no
            LEFT JOIN tb_retur_pembelian AS ret 
                ON inv.invoice_no = ret.invoice_no
            GROUP BY inv.invoice_no
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_invoice_pembelian_detail");
    }
};
