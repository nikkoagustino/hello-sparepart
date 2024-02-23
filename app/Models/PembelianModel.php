<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PembelianModel extends Model
{
    use HasFactory;

    static function getInvoice($invoice_no) {
        $result = DB::table('tb_pembelian_invoice_master')
                    ->where('invoice_no', $invoice_no)
                    ->first();
        return $result;
    }

    // static function getInvoiceDetail($invoice_no) {
    //     DB::statement('SET sql_mode=""');
    //     $result = DB::table('tb_pembelian_invoice_master AS inv')
    //                 ->where('inv.invoice_no', $invoice_no)
    //                 ->leftJoin('tb_supplier AS sup', 'inv.supplier_code', '=', 'sup.supplier_code')
    //                 ->leftJoin('tb_pembelian_invoice_items AS itm', 'inv.invoice_no', '=', 'itm.invoice_no')
    //                 ->select('inv.*', 'sup.*', DB::raw('SUM(itm.qty) AS total_qty, SUM(itm.subtotal_price) AS total_price'))
    //                 ->first();
    //     return $result;
    // }

    static function getInvoiceDetail($invoice_no) {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->where('invoice_no', $invoice_no)
                    ->first();
        return $result;
    }

    static function getInvoiceItems($invoice_no) {
        $result = DB::table('tb_pembelian_invoice_items AS itm')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code')
                    ->where('itm.invoice_no', $invoice_no)
                    ->select('itm.*', 'prd.type_code', 'prd.product_name')
                    ->get();
        return $result;
    }

    static function createInvoice($request) {
        $insert = DB::table('tb_pembelian_invoice_master')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'supplier_code' => $request->supplier_code,
                        'invoice_date' => $request->invoice_date,
                        'days_expire' => $request->days_expire,
                        'expiry_date' => date('Y-m-d', strtotime($request->invoice_date.' +'.$request->days_expire.' days')),
                        'description' => $request->description,
                        'payment_type' => $request->payment_type,
                    ]);
        return $insert;
    }

    static function addInvoiceItem($request) {
        $discounted_price = (int) ($request->normal_price - ($request->normal_price * ($request->discount_rate / 100)));
        $insert = DB::table('tb_pembelian_invoice_items')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'product_code' => $request->product_code,
                        'normal_price' => $request->normal_price,
                        'discount_rate' => $request->discount_rate,
                        'discounted_price' => $discounted_price,
                        'qty' => $request->qty,
                        'subtotal_price' => ($request->qty * $discounted_price),
                    ]);
        return $insert;
    }

    // static function getAllInvoice() {
    //     DB::statement('SET sql_mode=""');
    //     $result = DB::table('tb_pembelian_invoice_master AS inv')
    //                 ->leftJoin('tb_supplier AS sup', 'inv.supplier_code', '=', 'sup.supplier_code')
    //                 ->leftJoin('tb_pembelian_invoice_items AS itm', 'inv.invoice_no', '=', 'itm.invoice_no')
    //                 ->select('inv.*', 'sup.supplier_name', DB::raw('SUM(itm.qty) AS total_qty, SUM(itm.subtotal_price) AS total_price'))
    //                 ->groupBy('inv.invoice_no')
    //                 ->get();
    //     return $result;
    // }

    static function getAllInvoice() {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->get();
        return $result;
    }

    static function getAllReturInvoice() {
        $result = DB::table('view_invoice_pembelian_detail')
                    ->where('total_retur_qty', '>', 0)
                    ->get();
        return $result;
    }

    // static function getInvoices($request) {
    //     DB::statement('SET sql_mode=""');
    //     $query = DB::table('tb_pembelian_invoice_master AS inv')
    //                 ->leftJoin('tb_supplier AS sup', 'inv.supplier_code', '=', 'sup.supplier_code')
    //                 ->leftJoin('tb_pembelian_invoice_items AS itm', 'inv.invoice_no', '=', 'itm.invoice_no')
    //                 ->select('inv.*', 'sup.supplier_name', DB::raw('SUM(itm.qty) AS total_qty, SUM(itm.subtotal_price) AS total_price'))
    //                 ->groupBy('inv.invoice_no');

    //     if ($request->date_start) {
    //         $query->where('inv.invoice_date', '>=', $request->date_start);
    //     }
    //     if ($request->date_end) {
    //         $query->where('inv.invoice_date', '<=', $request->date_end);
    //     }
    //     if ($request->supplier_code) {
    //         $query->where('inv.supplier_code', '=', $request->supplier_code);
    //     }

    //     $result = $query->get();
    //     return $result;
    // }

    static function getInvoices($request) {
        $query = DB::table('view_invoice_pembelian_detail AS inv');
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        if ($request->supplier_code) {
            $query->where('inv.supplier_code', '=', $request->supplier_code);
        }
        $result = $query->get();
        return $result;
    }

    static function getPreviousPayment($invoice_no) {
        $result = DB::table('tb_pembelian_invoice_bayar')
                    ->where('invoice_no', $invoice_no)
                    ->get();
        return $result;
    }

    static function insertPayment($request, $payment_proof_path) {
        $insert = DB::table('tb_pembelian_invoice_bayar')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'paid_amount' => $request->paid_amount,
                        'payment_date' => $request->payment_date,
                        'payment_proof' => $payment_proof_path,
                    ]);
        return $insert;
    }

    static function deleteInvoiceItem($request) {
        $delete = DB::table('tb_pembelian_invoice_items')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->delete();
        return $delete;
    }

    static function getInvoiceTerhutang($request = null) {
        $query = DB::table('view_hutang_pembelian AS hut')
                    ->leftJoin('view_invoice_pembelian_detail AS inv', 'hut.invoice_no', '=', 'inv.invoice_no');
                    // ->where('hut.hutang', '>', 0);

        if ($request->invoice_no) {
            $query->whereRaw('inv.invoice_no LIKE "%'.$request->invoice_no.'%"');
        }

        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }

        if ($request->supplier_code) {
            $query->where('inv.supplier_code', $request->supplier_code);
        }

        if ($request->payment_type) {
            $query->where('inv.payment_type', $request->payment_type);
        }

        if ($request->status) {
            if ($request->status === 'lunas') {
                $query->where('hut.hutang', '<=', 0);
            } else {
                $query->where('hut.hutang', '>', 0);
            }
        }

        $result = $query->get();
        return $result;
    }

    static function getInvoiceLunas($request = null) {
        $query = DB::table('view_hutang_pembelian AS hut')
                    ->leftJoin('view_invoice_pembelian_detail AS inv', 'hut.invoice_no', '=', 'inv.invoice_no')
                    ->where('hut.hutang', '<=', 0);

        if ($request->invoice_no) {
            $query->whereRaw('inv.invoice_no LIKE "%'.$request->invoice_no.'%"');
        }

        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }

        if ($request->supplier_code) {
            $query->where('inv.supplier_code', $request->supplier_code);
        }

        if ($request->payment_type) {
            $query->where('inv.payment_type', $request->payment_type);
        }

        $result = $query->get();
        return $result;
    }

    static function filterTransaksi($request) {
        $query = DB::table('view_invoice_pembelian_detail AS inv')
                    ->leftJoin('tb_pembelian_invoice_items AS itm', 'inv.invoice_no', '=', 'itm.invoice_no')
                    ->leftJoin('view_hutang_pembelian AS hut', 'inv.invoice_no', '=', 'hut.invoice_no');

        if ($request->invoice_no) {
            $query->where('inv.invoice_no', '=', $request->invoice_no);
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }

        if ($request->supplier_code) {
            $query->where('inv.supplier_code', $request->supplier_code);
        }

        if ($request->product_code) {
            $query->where('itm.product_code', $request->product_code);
        }

        $query->select('inv.*', 'hut.total_paid_amount', 'hut.hutang');

        $result = $query->groupBy('inv.invoice_no')->get();
        return $result;
    }

    static function insertRetur($request) {
        $result = DB::table('tb_pembelian_invoice_items')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->first();

        $find = DB::table('tb_retur_pembelian')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->first();
        if ($find) {
            $delete = DB::table('tb_retur_pembelian')
                        ->where('invoice_no', $request->invoice_no)
                        ->where('product_code', $request->product_code)
                        ->delete();
        }

        $insert = DB::table('tb_retur_pembelian')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'product_code' => $request->product_code,
                        'qty' => $request->qty,
                        'normal_price' => $result->normal_price,
                        'discount_rate' => $result->discount_rate,
                        'discounted_price' => $result->discounted_price,
                        'subtotal_price' => $request->qty * $result->discounted_price,
                    ]);
        return $insert;
    }

    static function getReturnedItems($invoice_no) {
        $result = DB::table('tb_retur_pembelian AS itm')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code')
                    ->where('itm.invoice_no', $invoice_no)
                    ->select('itm.*', 'prd.type_code', 'prd.product_name')
                    ->get();
        return $result;
    }
    static function updateInvoiceItem($data) {
        $data = (array) $data;
        $update = DB::table('tb_pembelian_invoice_items')
                    ->where('invoice_no', $data['invoice_no'])
                    ->where('product_code', $data['product_code'])
                    ->update($data);
        return $update;
    }
}
