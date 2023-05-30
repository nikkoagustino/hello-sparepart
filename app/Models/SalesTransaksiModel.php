<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SalesTransaksiModel extends Model
{
    use HasFactory;

    static function getTransaksiSales($request) {
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->where('trx.sales_code', $request->sales_code)
                    ->whereRaw('YEAR(trx.tx_date) = '.$request->year.' AND MONTH(trx.tx_date) = '.$request->month)
                    ->select('trx.*', 'sal.sales_name')
                    ->get();
        return $result;
    }

    static function insertTx($request) {
        $insert = DB::table('tb_transaksi_sales')
                    ->insert([
                        'sales_code' => $request->sales_code,
                        'tx_date' => $request->tx_date,
                        'amount' => $request->amount,
                        'description' => $request->description,
                    ]);
        return $insert;
    }

    static function getTxById($id) {
        $result = DB::table('tb_transaksi_sales AS trx')
                    ->where('id', $id)
                    ->join('tb_sales AS sal', 'trx.sales_code', '=', 'sal.sales_code')
                    ->select('trx.*', 'sal.sales_name')
                    ->first();
        return $result;
    }

    static function updateTx($request) {
        $update = DB::table('tb_transaksi_sales')
                    ->where('id', $request->id)
                    ->update([
                        'tx_date' => $request->tx_date,
                        'amount' => $request->amount,
                        'description' => $request->description,
                    ]);
        return $update;
    }
}
