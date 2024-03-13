<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    use HasFactory;

    static function insert($request) {
        $insert = DB::table('tb_product')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_product')
                    ->orderBy('product_code', 'ASC')
                    ->join('tb_product_type', 'tb_product.type_code', '=', 'tb_product_type.type_code')
                    ->get();
        return $result;
    }

    static function getExportProduct() {
        $result = DB::table('tb_product')
                    ->get();
        return $result;
    }

    static function getById($product_code) {
        $result = DB::table('tb_product')
                    ->join('tb_product_type', 'tb_product.type_code', '=', 'tb_product_type.type_code')
                    ->where('product_code', $product_code)
                    ->first();
        return $result;
    }

    static function getInvoicePembelianByProduct($product_code) {
        $result = DB::table('tb_pembelian_invoice_items')
                    ->where('product_code', $product_code)
                    ->get();
        return $result;
    }

    static function getInvoicePenjualanByProduct($product_code) {
        $result = DB::table('tb_pembelian_invoice_items')
                    ->where('product_code', $product_code)
                    ->get();
        return $result;
    }

    static function deleteProduct($product_code) {
        $delete = DB::table('tb_product')
                    ->where('product_code', $product_code)
                    ->delete();
        return $delete;
    }

    static function edit($request) {
        $update = DB::table('tb_product')
                    ->where('product_code', $request->product_code)
                    ->update([
                        'product_name' => $request->product_name,
                        'price_capital' => $request->price_capital,
                        'price_selling' => $request->price_selling,
                        'type_code' => $request->type_code,
                        'qty_stok' => $request->qty_stok,
                    ]);
        return $update;
    }

    static function getProductTransactions($product_code) {
        $result = DB::table('view_product_transaction')
                    ->where('product_code', $product_code)
                    ->get();
        return $result;
    }

    static function searchProduct($request) {
        $query = DB::table('tb_product')->groupBy('product_code');
        if ($request->product_code) $query->where('product_code', 'like', '%'.$request->product_code.'%');
        if ($request->product_name) $query->where('product_name', 'like', '%'.$request->product_name.'%');
        return $query->get();
    }

    static function decrementProductQty($product_code, $qty = 1) {
        $update = DB::table('tb_product')
                    ->where('product_code', $product_code)
                    ->decrement('qty_stok', $qty);
        return $update;
    }

    static function incrementProductQty($product_code, $qty = 1) {
        $update = DB::table('tb_product')
                    ->where('product_code', $product_code)
                    ->increment('qty_stok', $qty);
        return $update;
    }
}
