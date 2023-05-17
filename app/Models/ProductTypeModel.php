<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductTypeModel extends Model
{
    use HasFactory;
    
    static function insert($request) {
        $insert = DB::table('tb_product_type')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_product_type')->get();
        return $result;
    }

    static function getById($type_code) {
        $result = DB::table('tb_product_type')
                    ->where('type_code', $type_code)
                    ->first();
        return $result;
    }

    static function getProductByTypeCode($type_code) {
        $result = DB::table('tb_product')
                    ->where('type_code', $type_code)
                    ->get();
        return $result;
    }

    static function getVBeltByTypeCode($type_code) {
        $result = DB::table('tb_vbelt')
                    ->where('type_code', $type_code)
                    ->get();
        return $result;
    }

    static function deleteProductType($type_code) {
        $delete = DB::table('tb_product_type')
                    ->where('type_code', $type_code)
                    ->delete();
        return $delete;
    }

    static function edit($request) {
        $update = DB::table('tb_product_type')
                    ->where('type_code', $request->type_code)
                    ->update([
                        'type_name' => $request->type_name,
                    ]);
        return $update;
    }
}
