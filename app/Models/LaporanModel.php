<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class LaporanModel extends Model
{
    use HasFactory;

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
}
