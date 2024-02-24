<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SalesModel extends Model
{
    use HasFactory;
    
    static function insert($request) {
        $insert = DB::table('tb_sales')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_sales')
                    ->orderBy('sales_code', 'ASC')
                    ->get();
        return $result;
    }

    static function getById($sales_code) {
        $result = DB::table('tb_sales')
                    ->where('sales_code', $sales_code)
                    ->first();
        return $result;
    }

    static function deleteSales($sales_code) {
        $delete = DB::table('tb_sales')
                    ->where('sales_code', $sales_code)
                    ->delete();
        return $delete;
    }

    static function editSales($request) {
        $update = DB::table('tb_sales')
                    ->where('sales_code', $request->sales_code)
                    ->update([
                        'sales_name' => $request->sales_name,
                        'address' => $request->address,
                        'phone_number_1' => $request->phone_number_1,
                        'phone_number_2' => $request->phone_number_2,
                    ]);
        return $update;
    }

    static function searchSales($request) {
        $query = DB::table('tb_sales');
        if ($request->sales_code) $query->where('sales_code', 'like', '%'.$request->sales_code.'%');
        if ($request->sales_name) $query->where('sales_name', 'like', '%'.$request->sales_name.'%');
        return $query->get();
    }
}
