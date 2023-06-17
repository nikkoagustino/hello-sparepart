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
            CREATE VIEW view_labarugi_per_periode AS
            SELECT 
                CAST(inv.year AS SIGNED) AS year,
                CAST(inv.month AS SIGNED) AS month,
                CAST(COALESCE(inv.penjualan_kotor - mdl.total_modal, 0) AS SIGNED) AS laba_kotor,
                CAST(COALESCE(kom.komisi_sales, 0) AS SIGNED) AS komisi_sales,
                CAST(COALESCE(trx.beban_ops, 0) AS SIGNED) AS beban_ops,
                CAST(COALESCE(kom.komisi_sales + trx.beban_ops, 0) AS SIGNED) AS total_pengeluaran,
                CAST((COALESCE(inv.penjualan_kotor - mdl.total_modal, 0) - COALESCE(kom.komisi_sales + trx.beban_ops, 0)) AS SIGNED) AS laba_bersih
            FROM
                (SELECT YEAR(inv.invoice_date) AS year,
                    MONTH(inv.invoice_date) AS month,
                    SUM(inv.total_price) AS penjualan_kotor
                FROM view_invoice_penjualan_detail AS inv
                GROUP BY YEAR(inv.invoice_date), MONTH(inv.invoice_date)) AS inv
            LEFT JOIN
                (SELECT YEAR(mdl.invoice_date) AS year,
                    MONTH(mdl.invoice_date) AS month,
                    SUM(mdl.subtotal_modal) AS total_modal
                FROM view_invoice_jual_modal AS mdl
                GROUP BY YEAR(mdl.invoice_date), MONTH(mdl.invoice_date)) AS mdl
            ON inv.year = mdl.year AND inv.month = mdl.month
            LEFT JOIN
                (SELECT YEAR(kom.invoice_date) AS year,
                    MONTH(kom.invoice_date) AS month,
                    FLOOR(SUM(kom.paid_amount * (COALESCE(komisi.persen_komisi, 0) / 100))) AS komisi_sales
                FROM view_tabel_komisi_sales AS kom
                LEFT JOIN tb_komisi_sales AS komisi
                    ON YEAR(kom.invoice_date) = komisi.year 
                        AND MONTH(kom.invoice_date) = komisi.month
                        AND kom.sales_code = komisi.sales_code
                GROUP BY YEAR(kom.invoice_date), MONTH(kom.invoice_date)) AS kom
            ON inv.year = kom.year AND inv.month = kom.month
            LEFT JOIN
                (SELECT YEAR(trx.tx_date) AS year,
                    MONTH(trx.tx_date) AS month,
                    SUM(trx.amount) AS beban_ops
                FROM tb_transaksi_sales AS trx
                GROUP BY YEAR(trx.tx_date), MONTH(trx.tx_date)) AS trx
            ON inv.year = trx.year AND inv.month = trx.month
            ORDER BY inv.year ASC, inv.month ASC
            ;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_labarugi_per_periode");
    }
};
