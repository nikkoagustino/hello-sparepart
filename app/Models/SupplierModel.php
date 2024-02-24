<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SupplierModel extends Model
{
    use HasFactory;

    static function insert($request) {
        $insert = DB::table('tb_supplier')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_supplier')->get();
        return $result;
    }

    static function getById($supplier_code) {
        $result = DB::table('tb_supplier')
                    ->where('supplier_code', $supplier_code)
                    ->first();
        return $result;
    }

    static function getInvoiceBySupplier($supplier_code) {
        $result = DB::table('tb_pembelian_invoice_master')
                    ->where('supplier_code', $supplier_code)
                    ->get();
        return $result;
    }

    static function deleteSupplier($supplier_code) {
        $delete = DB::table('tb_supplier')
                    ->where('supplier_code', $supplier_code)
                    ->delete();
        return $delete;
    }

    static function edit($request) {
        $update = DB::table('tb_supplier')
                    ->where('supplier_code', $request->supplier_code)
                    ->update([
                        'supplier_name' => $request->supplier_name,
                        'address' => $request->address,
                        'phone_number_1' => $request->phone_number_1,
                        'phone_number_2' => $request->phone_number_2,
                        'contact_person' => $request->contact_person,
                    ]);
        return $update;
    }

    static function searchSupplier($request) {
        $query = DB::table('tb_supplier');
        if ($request->supplier_code) $query->where('supplier_code', 'like', '%'.$request->supplier_code.'%');
        if ($request->supplier_name) $query->where('supplier_name', 'like', '%'.$request->supplier_name.'%');
        return $query->get();
    }
}
