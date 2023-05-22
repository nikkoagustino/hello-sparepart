<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AbsensiModel extends Model
{
    use HasFactory;

    static function addAbsen($request) {
        $insert = DB::table('tb_absensi')
                    ->insert([
                        'sales_code' => $request->sales_code,
                        'tanggal' => $request->tanggal,
                        'jam' => $request->jam,
                        'type' => $request->type,
                    ]);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_absensi')
                    ->leftJoin('tb_sales', 'tb_absensi.sales_code', '=', 'tb_sales.sales_code')
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('tb_absensi.sales_code', 'asc')
                    ->orderBy('jam', 'asc')
                    ->get();
        return $result;
    }
}