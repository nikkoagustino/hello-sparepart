<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class LaporanModel extends Model
{
    use HasFactory;

    static function getPenjualanKotor($request) {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->whereRaw('YEAR(invoice_date) = '.$request->year)
                    ->whereRaw('MONTH(invoice_date) >= '.$request->month_start.' AND MONTH(invoice_date) <= '.$request->month_end)
                    ->sum('total_price');
        return $result;
    }

    static function getModalBersih($request) {
        $result = DB::table('view_invoice_jual_modal')
                    ->whereRaw('YEAR(invoice_date) = '.$request->year)
                    ->whereRaw('MONTH(invoice_date) >= '.$request->month_start.' AND MONTH(invoice_date) <= '.$request->month_end)
                    ->sum('subtotal_modal');
        return $result;
    }

    static function getKomisiSales($request) {
        $result = DB::table('view_tabel_komisi_sales')
                    ->whereRaw('YEAR(invoice_date) = '.$request->year)
                    ->whereRaw('MONTH(invoice_date) >= '.$request->month_start.' AND MONTH(invoice_date) <= '.$request->month_end)
                    ->sum('paid_amount');
        return $result;
    }

    static function getGajiSales($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'like', '%gaji%')
                    ->sum('trx.amount');
        return $result;
    }

    static function getKomisiSalesDetail($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('view_tabel_komisi_sales AS vw')
                    ->join('tb_sales AS sal', 'vw.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(vw.invoice_date) = '.$request->year)
                    ->whereRaw('MONTH(vw.invoice_date) >= '.$request->month_start.' AND MONTH(vw.invoice_date) <= '.$request->month_end)
                    ->groupBy('vw.sales_code')
                    ->select('vw.sales_code', 'sal.sales_name', DB::raw('SUM(vw.paid_amount) AS komisi'))
                    ->get();
        return $result;
    }

    static function getGajiSalesDetail($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'like', '%gaji%')
                    ->groupBy('trx.sales_code')
                    ->select('trx.sales_code', 'sal.sales_name', DB::raw('SUM(trx.amount) AS gaji'))
                    ->get();
        return $result;
    }

    static function getInventarisSum($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'like', '%inventaris%')
                    ->sum('trx.amount');
        return $result;
    }

    static function getReimburseSum($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'like', '%reimburse%')
                    ->sum('trx.amount');
        return $result;
    }

    static function getPulsaSum($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'like', '%pulsa%')
                    ->sum('trx.amount');
        return $result;
    }

    static function getBebanOpsOtherSum($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year)
                    ->whereRaw('MONTH(trx.tx_date) >= '.$request->month_start.' AND MONTH(trx.tx_date) <= '.$request->month_end)
                    ->where('trx.description', 'not like', '%inventaris%')
                    ->where('trx.description', 'not like', '%reimburse%')
                    ->where('trx.description', 'not like', '%pulsa%')
                    ->where('trx.description', 'not like', '%gaji%')
                    ->sum('trx.amount');
        return $result;
    }

    static function getBebanOps($request) {
        DB::statement('SET SQL_MODE=""');
        $result = DB::table('tb_transaksi_sales')
                    ->whereRaw('YEAR(tx_date) = '.$request->year)
                    ->whereRaw('MONTH(tx_date) >= '.$request->month_start.' AND MONTH(tx_date) <= '.$request->month_end)
                    ->where('description', 'not like', '%gaji%')
                    ->sum('amount');
        return $result;
    }

    static function getMonthlyExpense($current_date) {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->whereRaw('YEAR(invoice_date) = '.date('Y', strtotime($current_date)).' AND MONTH(invoice_date) = '.date('m', strtotime($current_date)))
                    ->select(DB::raw('SUM(total_price) AS expense'))
                    ->first();
        return $result;
    }

    static function getMonthlyIncome($current_date) {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->whereRaw('YEAR(invoice_date) = '.date('Y', strtotime($current_date)).' AND MONTH(invoice_date) = '.date('m', strtotime($current_date)))
                    ->select(DB::raw('SUM(total_price) AS income'))
                    ->first();
        return $result;
    }

    static function getBestSeller() {
        $result = DB::table('tb_penjualan_invoice_items')
                    ->select('product_code', DB::raw('SUM(qty) AS total_qty'))
                    ->orderBy('total_qty', 'DESC')
                    ->groupBy('product_code')
                    ->limit(10)
                    ->get();
        return $result;
    }

    static function getBestCustomer() {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->select('customer_code', 'customer_name', DB::raw('SUM(total_invoice_price) AS total_price'))
                    ->orderBy('total_price', 'DESC')
                    ->groupBy('customer_code')
                    ->limit(10)
                    ->get();
        return $result;
    }

    static function getExpenseBulanan($range) {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->where('invoice_date', '>=', Carbon::now()->subMonths($range)->startOfMonth())
                    ->where('invoice_date', '<=', Carbon::now()->endOfMonth())
                    ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
                    ->select(DB::raw('SUM(total_price) AS amount, MONTHNAME(invoice_date) AS month'))
                    ->orderBy('month', 'asc')
                    ->get();
        return $result;
    }

    static function getIncomeBulanan($range) {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->where('invoice_date', '>=', Carbon::now()->subMonths($range)->startOfMonth())
                    ->where('invoice_date', '<=', Carbon::now()->endOfMonth())
                    ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
                    ->select(DB::raw('SUM(total_price) AS amount, MONTHNAME(invoice_date) AS month'))
                    ->orderBy('month', 'asc')
                    ->get();
        return $result;
    }

    static function getIncomeByMonth($year, $month) {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->whereRaw('YEAR(invoice_date) = '.$year.' AND MONTH(invoice_date) = '.$month)
                    ->select(DB::raw('SUM(total_price) AS amount, MONTHNAME(invoice_date) AS month'))
                    ->first();
        return $result;
    }
    static function getExpenseByMonth($year, $month) {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->whereRaw('YEAR(invoice_date) = '.$year.' AND MONTH(invoice_date) = '.$month)
                    ->select(DB::raw('SUM(total_price) AS amount, MONTHNAME(invoice_date) AS month'))
                    ->first();
        return $result;
    }

    static function getModalByMonth($year, $month) {
        $result = DB::table('view_invoice_jual_modal')
                    ->whereRaw('YEAR(invoice_date) = '.$year.' AND MONTH(invoice_date) = '.$month)
                    ->select(DB::raw('SUM(subtotal_modal) AS modal, MONTHNAME(invoice_date) AS month'))
                    ->first();
        return $result;
    }

    static function getBebanOpsByMonth($year, $month) {
        $result = DB::table('tb_transaksi_sales')
                    ->where('expense_type', 'beban_ops')
                    ->whereRaw('YEAR(tx_date) = '.$year.' AND MONTH(tx_date) = '.$month)
                    ->get();
        return $result;
    }

    static function getKomisiSalesByMonth($year, $month) {
        $komisi = DB::table('tb_komisi_sales')
                    ->where('year', $year)
                    ->where('month', $month)
                    ->get();
        $persen = [];                    
        foreach ($komisi as $row) {
            $persen[$row->sales_code] = $row->persen_komisi;
        }

        $invoice_paid = DB::table('view_tabel_komisi_sales')
                            ->groupBy('sales_code')
                            ->whereRaw('YEAR(invoice_date) = '.$year.' AND MONTH(invoice_date) = '.$month)
                            ->select(DB::raw('sales_code, SUM(paid_amount) AS total_paid_amount'))
                            ->get();
        $komisi_array = [];                            
        foreach ($invoice_paid as $row) {
            $data_row = [
                'sales_code' => $row->sales_code,
                'total_paid_amount' => (int) $row->total_paid_amount,
                'persen_komisi' => (float) ($persen[$row->sales_code] ?? 0),
                'total_komisi' => (int) $row->total_paid_amount * (float) (($persen[$row->sales_code] ?? 0) / 100),
            ];
            array_push($komisi_array, $data_row);
        }
        return $komisi_array;
    }

    static function getGajiSalesByMonth($year, $month) {
        $result = DB::table('tb_transaksi_sales')
                    ->where('expense_type', 'gaji')
                    ->whereRaw('YEAR(tx_date) = '.$year.' AND MONTH(tx_date) = '.$month)
                    ->get();
        return $result;
    }

    static function saveBebanOps($request) {
        $periode = $request->year.'-'.$request->month;
        $isset = DB::table('tb_beban_ops')
                    ->where('periode', $periode)
                    ->first();

        if ($isset) {
            $update = DB::table('tb_beban_ops')
                        ->where('periode', $periode)
                        ->update([
                            'inventaris' => $request->inventaris,
                            'reimburse' => $request->reimburse,
                            'pulsa' => $request->pulsa,
                        ]);
            return $update;
        } else {
            $insert = DB::table('tb_beban_ops')
                        ->insert([
                            'inventaris' => $request->inventaris,
                            'reimburse' => $request->reimburse,
                            'pulsa' => $request->pulsa,
                            'periode' => $periode,
                        ]);
            return $insert;
        }
    }

    static function saveKomisi($request) {
        $isset = DB::table('tb_komisi_sales')
                    ->where('periode', $request->periode)
                    ->where('sales_code', $request->sales_code)
                    ->first();

        if ($isset) {
            $update = DB::table('tb_komisi_sales')
                        ->where('periode', $request->periode)
                        ->where('sales_code', $request->sales_code)
                        ->update([
                            'amount' => $request->amount,
                        ]);
            return $update;
        } else {
            $insert = DB::table('tb_komisi_sales')
                        ->insert([
                            'sales_code' => $request->sales_code,
                            'amount' => $request->amount,
                            'periode' => $request->periode,
                        ]);
            return $insert;
        }
    }

    static function saveGaji($request) {
        $isset = DB::table('tb_gaji_sales')
                    ->where('periode', $request->periode)
                    ->where('sales_code', $request->sales_code)
                    ->first();

        if ($isset) {
            $update = DB::table('tb_gaji_sales')
                        ->where('periode', $request->periode)
                        ->where('sales_code', $request->sales_code)
                        ->update([
                            'amount' => $request->amount,
                        ]);
            return $update;
        } else {
            $insert = DB::table('tb_gaji_sales')
                        ->insert([
                            'sales_code' => $request->sales_code,
                            'amount' => $request->amount,
                            'periode' => $request->periode,
                        ]);
            return $insert;
        }
    }

    static function getLaporanProduct($request) {
        $query = DB::table('view_labarugi_product');
        if ($request->product_code) {
            $query->where('product_code', $request->product_code);
        }
        if ($request->date_start) {
            $query->where('invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('invoice_date', '<=', $request->date_end);
        }
        $result = $query->select(DB::raw('SUM(total_modal) AS total_modal, SUM(total_penjualan) AS total_penjualan, SUM(total_laba) AS total_laba'))->first();
        return $result;
    }
    static function getLaporanProductType($request) {
        $query = DB::table('view_labarugi_product');
        if ($request->type_code) {
            $query->where('type_code', $request->type_code);
        }
        if ($request->date_start) {
            $query->where('invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('invoice_date', '<=', $request->date_end);
        }
        $result = $query->select(DB::raw('SUM(total_modal) AS total_modal, SUM(total_penjualan) AS total_penjualan, SUM(total_laba) AS total_laba'))->first();
        return $result;
    }

    static function getYearlyLabaRugi($year) {
        $result = DB::table('view_labarugi_per_periode')
                    ->where('year', $year)
                    ->orderBy('month', 'asc')
                    ->get();
        return $result;
    }

    static function getRekapPenjualanProduk($request) {
        DB::statement('SET SQL_MODE=""');
        $query = DB::table('tb_penjualan_invoice_items AS itm')
                    ->leftJoin('tb_penjualan_invoice_master AS inv', 'itm.invoice_no', '=', 'inv.invoice_no')
                    ->leftJoin('tb_customer AS cust', 'inv.customer_code', '=', 'cust.customer_code')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code');
        if ($request->product_code) {
            $query->where('itm.product_code', $request->product_code);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        $result = $query->select('cust.customer_name', 'prd.price_capital AS modal', 'itm.discounted_price AS harga_jual', 'itm.qty')
                        ->get();
        return $result;
    }

    static function getRekapPembelianProduk($request) {
        DB::statement('SET SQL_MODE=""');
        $query = DB::table('tb_pembelian_invoice_items AS itm')
                    ->leftJoin('tb_pembelian_invoice_master AS inv', 'itm.invoice_no', '=', 'inv.invoice_no')
                    ->leftJoin('tb_supplier AS supp', 'inv.supplier_code', '=', 'supp.supplier_code')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code');
        if ($request->product_code) {
            $query->where('itm.product_code', $request->product_code);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        $result = $query->select('supp.supplier_name', 'itm.normal_price AS harga_normal', 'itm.discounted_price AS harga_beli', 'itm.discount_rate AS discount', 'itm.qty')
                        ->get();
        return $result;
    }

    static function getRekapPenjualanJenisBarang($request) {
        DB::statement('SET SQL_MODE=""');
        $query = DB::table('tb_penjualan_invoice_items AS itm')
                    ->leftJoin('tb_penjualan_invoice_master AS inv', 'itm.invoice_no', '=', 'inv.invoice_no')
                    ->leftJoin('tb_customer AS cust', 'inv.customer_code', '=', 'cust.customer_code')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code');
        if ($request->type_code) {
            $query->where('prd.type_code', $request->type_code);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        $result = $query->select('prd.product_code', 'prd.product_name', 'cust.customer_name AS nama', 'itm.discounted_price AS harga', 'itm.qty')
                        ->get();
        return $result;
    }

    static function getRekapPembelianJenisBarang($request) {
        DB::statement('SET SQL_MODE=""');
        $query = DB::table('tb_pembelian_invoice_items AS itm')
                    ->leftJoin('tb_pembelian_invoice_master AS inv', 'itm.invoice_no', '=', 'inv.invoice_no')
                    ->leftJoin('tb_supplier AS supp', 'inv.supplier_code', '=', 'supp.supplier_code')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code');
        if ($request->type_code) {
            $query->where('prd.type_code', $request->type_code);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        $result = $query->select('prd.product_code', 'prd.product_name', 'supp.supplier_name AS nama', 'itm.discounted_price AS harga', 'itm.qty')
                        ->get();
        return $result;
    }

    static function getRekapCustomer($request) {
        DB::statement('SET SQL_MODE=""');
        $query = DB::table('tb_penjualan_invoice_items AS itm')
                    ->leftJoin('tb_penjualan_invoice_master AS inv', 'itm.invoice_no', '=', 'inv.invoice_no')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code');
        if ($request->customer_code) {
            $query->where('inv.customer_code', $request->customer_code);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        $result = $query->select('itm.product_code', 'prd.type_code', 'prd.product_name', 'itm.qty', 'itm.normal_price', 'itm.discount_rate', 'itm.subtotal_price')
                        ->get();
        return $result;
    }
}
