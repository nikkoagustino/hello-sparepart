<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PenjualanModel extends Model
{
    use HasFactory;

    static function getInvoice($invoice_no) {
        $result = DB::table('tb_penjualan_invoice_master')
                    ->where('invoice_no', $invoice_no)
                    ->first();
        return $result;
    }
    static function getInvoiceDetail($invoice_no) {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->where('invoice_no', $invoice_no)
                    ->first();
        return $result;
    }

    static function getInvoiceItems($invoice_no) {
        $result = DB::table('tb_penjualan_invoice_items AS itm')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code')
                    ->where('itm.invoice_no', $invoice_no)
                    ->select('itm.*', 'prd.type_code', 'prd.product_name')
                    ->get();
        return $result;
    }

    static function createInvoice($request) {
        $insert = DB::table('tb_penjualan_invoice_master')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'customer_code' => $request->customer_code,
                        'sales_code' => $request->sales_code,
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
        $insert = DB::table('tb_penjualan_invoice_items')
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

    static function getAllInvoice() {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->get();
        return $result;
    }
    static function getInvoices($request) {
        $query = DB::table('view_invoice_penjualan_detail AS inv');
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }
        if ($request->customer_code) {
            $query->where('inv.customer_code', '=', $request->customer_code);
        }
        if ($request->sales_code) {
            $query->where('inv.sales_code', '=', $request->sales_code);
        }
        $result = $query->get();
        return $result;
    }

    static function getPreviousPayment($invoice_no) {
        $result = DB::table('tb_penjualan_invoice_bayar')
                    ->where('invoice_no', $invoice_no)
                    ->get();
        return $result;
    }

    static function insertPayment($request, $payment_proof_path) {
        $insert = DB::table('tb_penjualan_invoice_bayar')
                    ->insert([
                        'invoice_no' => $request->invoice_no,
                        'paid_amount' => $request->paid_amount,
                        'payment_date' => $request->payment_date,
                        'payment_proof' => $payment_proof_path,
                    ]);
        return $insert;
    }

    static function deleteInvoiceItem($request) {
        $delete = DB::table('tb_penjualan_invoice_items')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->delete();
        return $delete;
    }

    static function getInvoicePiutang($request = null) {
        $query = DB::table('view_piutang_penjualan AS piu')
                    ->leftJoin('view_invoice_penjualan_detail AS inv', 'piu.invoice_no', '=', 'inv.invoice_no')
                    ->where('piu.piutang', '>', 0);

        if ($request->invoice_no) {
            $query->whereRaw('inv.invoice_no LIKE "%'.$request->invoice_no.'%"');
        }

        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }

        if ($request->customer_code) {
            $query->where('inv.customer_code', $request->customer_code);
        }

        if ($request->sales_code) {
            $query->where('inv.sales_code', $request->sales_code);
        }

        if ($request->payment_type) {
            $query->where('inv.payment_type', $request->payment_type);
        }

        if ($request->status) {
            if ($request->status === 'lunas') {
                $query->where('piu.piutang', '<=', 0);
            } else {
                $query->where('piu.piutang', '>', 0);
            }
        }

        $result = $query->get();
        return $result;
    }
    
    static function getInvoiceLunas($request = null) {
        $query = DB::table('view_piutang_penjualan AS piu')
                    ->leftJoin('view_invoice_penjualan_detail AS inv', 'piu.invoice_no', '=', 'inv.invoice_no')
                    ->where('piu.piutang', '<=', 0);

        if ($request) {
            
            if ($request->invoice_no) {
                $query->whereRaw('inv.invoice_no LIKE "%'.$request->invoice_no.'%"');
            }

            if ($request->date_start) {
                $query->where('inv.invoice_date', '>=', $request->date_start);
            }

            if ($request->date_end) {
                $query->where('inv.invoice_date', '<=', $request->date_end);
            }

            if ($request->customer_code) {
                $query->where('inv.customer_code', $request->customer_code);
            }

            if ($request->sales_code) {
                $query->where('inv.sales_code', $request->sales_code);
            }

            if ($request->payment_type) {
                $query->where('inv.payment_type', $request->payment_type);
            }
        }

        $result = $query->get();
        return $result;
    }

    static function filterTransaksi($request) {
        $query = DB::table('view_invoice_penjualan_detail AS inv')
                    ->leftJoin('tb_penjualan_invoice_items AS itm', 'inv.invoice_no', '=', 'itm.invoice_no')
                    ->leftJoin('view_piutang_penjualan AS hut', 'inv.invoice_no', '=', 'hut.invoice_no');

        if ($request->invoice_no) {
            $query->where('inv.invoice_no', 'like', '%'.$request->invoice_no.'%');
        }
        if ($request->date_start) {
            $query->where('inv.invoice_date', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('inv.invoice_date', '<=', $request->date_end);
        }

        if ($request->customer_code) {
            $query->where('inv.customer_code', $request->customer_code);
        }

        if ($request->sales_code) {
            $query->where('inv.sales_code', $request->sales_code);
        }

        if ($request->product_code) {
            $query->where('itm.product_code', $request->product_code);
        }

        $query->select('inv.*', 'hut.total_paid_amount', 'hut.piutang');

        $result = $query->groupBy('inv.invoice_no')->get();
        return $result;
    }

    static function insertRetur($request) {
        $result = DB::table('tb_penjualan_invoice_items')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->first();

        $find = DB::table('tb_retur_penjualan')
                    ->where('invoice_no', $request->invoice_no)
                    ->where('product_code', $request->product_code)
                    ->first();
        if ($find) {
            $delete = DB::table('tb_retur_penjualan')
                        ->where('invoice_no', $request->invoice_no)
                        ->where('product_code', $request->product_code)
                        ->delete();
        }

        $insert = DB::table('tb_retur_penjualan')
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
        $result = DB::table('tb_retur_penjualan AS itm')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code')
                    ->where('itm.invoice_no', $invoice_no)
                    ->select('itm.*', 'prd.type_code', 'prd.product_name')
                    ->get();
        return $result;
    }


    static function getAllReturInvoice() {
        $result = DB::table('view_invoice_penjualan_detail')
                    ->where('total_retur_qty', '>', 0)
                    ->get();
        return $result;
    }

    static function updateInvoiceItem($data) {
        $data = (array) $data;
        $update = DB::table('tb_penjualan_invoice_items')
                    ->where('invoice_no', $data['invoice_no'])
                    ->where('product_code', $data['product_code'])
                    ->update($data);
        return $update;
    }

    static function getReturByID($id) {
        $result = DB::table('tb_retur_penjualan AS itm')
                    ->leftJoin('tb_product AS prd', 'itm.product_code', '=', 'prd.product_code')
                    ->where('itm.id', $id)
                    ->select('itm.*', 'prd.type_code', 'prd.product_name')
                    ->first();
        return $result;
    }

    static function deleteReturByID($id) {
        $delete = DB::table('tb_retur_penjualan')
                    ->where('id', $id)
                    ->delete();
        return $delete;
    }
}
