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
            CREATE VIEW view_product_transaction AS
            SELECT itm.product_code, itm.invoice_no, mst.invoice_date, 'JUAL' AS status, mst.customer_code AS cust_supp_code, cust.customer_name AS cust_supp_name, itm.qty, itm.subtotal_price
            FROM tb_penjualan_invoice_items AS itm
            LEFT JOIN tb_penjualan_invoice_master AS mst
                ON itm.invoice_no = mst.invoice_no
            LEFT JOIN tb_customer AS cust
                ON mst.customer_code = cust.customer_code

            UNION ALL

            SELECT itm.product_code, itm.invoice_no, mst.invoice_date, 'BELI' AS status, mst.supplier_code AS cust_supp_code, supp.supplier_name AS cust_supp_name, itm.qty, itm.subtotal_price
            FROM tb_pembelian_invoice_items AS itm
            LEFT JOIN tb_pembelian_invoice_master AS mst
                ON itm.invoice_no = mst.invoice_no
            LEFT JOIN tb_supplier AS supp
                ON mst.supplier_code = supp.supplier_code

            UNION ALL

            SELECT itm.product_code, itm.invoice_no, mst.invoice_date, 'RETUR-JUAL' AS status, mst.customer_code AS cust_supp_code, cust.customer_name AS cust_supp_name, itm.qty, itm.subtotal_price
            FROM tb_retur_penjualan AS itm
            LEFT JOIN tb_penjualan_invoice_master AS mst
                ON itm.invoice_no = mst.invoice_no
            LEFT JOIN tb_customer AS cust
                ON mst.customer_code = cust.customer_code

            UNION ALL

            SELECT itm.product_code, itm.invoice_no, mst.invoice_date, 'RETUR-BELI' AS status, mst.supplier_code AS cust_supp_code, supp.supplier_name AS cust_supp_name, itm.qty, itm.subtotal_price
            FROM tb_retur_pembelian AS itm
            LEFT JOIN tb_pembelian_invoice_master AS mst
                ON itm.invoice_no = mst.invoice_no
            LEFT JOIN tb_supplier AS supp
                ON mst.supplier_code = supp.supplier_code

            ORDER BY invoice_date DESC
            ;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_product_transaction");
    }
};
