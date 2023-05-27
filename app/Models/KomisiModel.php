<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class KomisiModel extends Model
{
    use HasFactory;

    static function getSalesInvoice($request) {
        $result = DB::table('view_tabel_komisi_sales')
                    ->where('sales_code', $request->sales_code)
                    ->whereRaw('YEAR(invoice_date) = '.$request->year.' AND MONTH(invoice_date) = '.$request->month)
                    ->get();
        return $result;
    }
    static function getPercentKomisi($request) {
        $result = DB::table('tb_komisi_sales')
                    ->where('sales_code', $request->sales_code)
                    ->where('year', $request->year)
                    ->where('month', $request->month)
                    ->first();
        if ($result) {
            return $result->persen_komisi;
        } else {
            return 0;
        }
    }

    static function upsertKomisi($request) {
        $result = DB::table('tb_komisi_sales')
                    ->where('sales_code', $request->sales_code)
                    ->where('year', $request->year)
                    ->where('month', $request->month)
                    ->first();
        if ($result) {
            $update = DB::table('tb_komisi_sales')
                    ->where('sales_code', $request->sales_code)
                    ->where('year', $request->year)
                    ->where('month', $request->month)
                    ->update([
                        'persen_komisi' => $request->persen_komisi,
                    ]);
            return $update;
        } else {
            $insert = DB::table('tb_komisi_sales')
                    ->insert([
                        'sales_code' => $request->sales_code,
                        'year' => $request->year,
                        'month' => $request->month,
                        'persen_komisi' => $request->persen_komisi,
                    ]);
            return $insert;
        }
    }
}
