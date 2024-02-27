<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use App\Models\SalesModel;
use App\Models\SupplierModel;
use App\Models\PenjualanModel;
use App\Models\ProductModel;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Str;

class PenjualanController extends Controller
{
    function showInvoiceHome() {
        return view('admin/penjualan/invoice-home');
    }

    function formNewInvoice() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/penjualan/invoice-new')->with($data);
    }

    function createInvoice(Request $request) {
        $request->validate([
            'invoice_no' => 'required|unique:tb_penjualan_invoice_master,invoice_no|regex:/^[a-zA-Z0-9_\.\-\/]+$/',
            'customer_code' => 'required|string',
            'sales_code' => 'required|string',
            'invoice_date' => 'required|date',
            'days_expire' => 'required|integer',
            'description' => 'nullable|string',
            'payment_type' => 'required|string',

            'product_code.*' => 'required|string',
            'normal_price.*' => 'required|integer',
            'discount_rate.*' => 'required|numeric',
            'qty.*' => 'required|integer',

            'is_print' => 'required|boolean',
        ]);

        $master_add = PenjualanModel::createInvoice($request);

        // Insert invoice data
        foreach ($request->input('product_code') as $index => $value) {
            $data = [
                'invoice_no' => $request->invoice_no,
                'product_code' => $request->input('product_code')[$index],
                'normal_price' => $request->input('normal_price')[$index],
                'discount_rate' => $request->input('discount_rate')[$index],
                'qty' => $request->input('qty')[$index],
            ];
            $data = (object) $data;
            $item_add = PenjualanModel::addInvoiceItem($data);
        }
        if ($master_add) {
            $request->session()->flash('is_print', (int) $request->is_print);
            $request->session()->flash('invoice_no', $request->invoice_no);
            return redirect('admin/penjualan/invoice')->withSuccess('Berhasil membuat invoice');
        } else {
            return redirect()->back()->withErrors('Gagal membuat invoice');
        }

    }
    function getInvoiceByInvNo(Request $request) {
        $response = PenjualanModel::getInvoiceDetail($request->invoice_no);
        if ($response) {
            return response()->json([
                'success' => true,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No Data Available'
            ], 404);
        }
    }

    function getInvoiceItemsByInvNo(Request $request) {
        $response = PenjualanModel::getInvoiceItems($request->invoice_no);
        if ($response) {
            return response()->json([
                'success' => true,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No Data Available'
            ], 404);
        }
    }

    function showInvoiceDetail() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
            'products' => ProductModel::getAll()
        ];
        return view('admin/penjualan/invoice-detail')->with($data);
    }

    function showInvoiceList() {
        $data = [
            'invoices' => PenjualanModel::getAllInvoice(),
            'customers' => CustomerModel::getAll()
        ];
        return view('admin/penjualan/invoice-list')->with($data);
    }

    function printInvoiceList() {
        $data = [
            'invoices' => PenjualanModel::getAllInvoice(),
        ];
        return view('admin/print/invoice-sell-list')->with($data);
    }

    function printInvoiceLunas() {
        $data = [
            'invoices' => PenjualanModel::getInvoiceLunas(),
        ];
        return view('admin/print/invoice-sell-list')->with($data);
    }

    function printInvoicePiutang(Request $request) {
        $data = [
            'invoices' => PenjualanModel::getInvoicePiutang($request),
        ];

        $pdf = \PDF::loadView('admin/print/invoice-sell-list', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function printInvoice(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'master' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'items' => PenjualanModel::getInvoiceItems($request->invoice_no),
            'retur' => PenjualanModel::getReturnedItems($request->invoice_no)
        ];
        $pdf = \PDF::loadView('admin/print/invoice-sell', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
        // return view('admin/print/invoice-sell')->with($data);
    }

    function showPembayaranHome() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/penjualan/invoice-payment')->with($data);
    }

    function showPembayaranInvoice(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'payments' => PenjualanModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/penjualan/piutang-bayar')->with($data);
    }

    function savePembayaran(Request $request) {
        $request->validate([
            'invoice_no' => 'required|string',
            'paid_amount' => 'required|integer',
            'payment_date' => 'required|date',
            'payment_proof_file' => 'nullable|image'
        ]);

        // Upload file
        $upload_path = null;
        if ($request->hasFile('payment_proof_file')) {
            $file = $request->file('payment_proof_file');
            $file_path = 'penjualan_payment_proof';
            $file_name = time().' '.$request->invoice_no.' '.$request->payment_date.'.webp';

            $img = Image::make($file)
                        ->encode('webp', 80)
                        ->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream();
            $upload = Storage::put($file_path.'/'.$file_name, $img);
            $upload_path = $file_path.'/'.$file_name;
        }

        // Insert pembayaran
        if (PenjualanModel::insertPayment($request, $upload_path)) {
            if (Str::contains($request->redirect_to, 'dashboard')) {
                return redirect('admin/dashboard/piutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
            } else {
                return redirect('admin/penjualan/piutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
            }
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function editPembayaran(Request $request) {
        $request->validate([
            'edit_id' => 'required|exists:tb_penjualan_invoice_bayar,id',
            'invoice_no' => 'required|string',
            'edit_paid_amount' => 'required|integer',
            'edit_payment_date' => 'required|date',
            'edit_payment_proof_file' => 'nullable|image'
        ]);

        // Upload file
        $upload_path = null;
        if ($request->hasFile('edit_payment_proof_file')) {
            $file = $request->file('edit_payment_proof_file');
            $file_path = 'pembelian_payment_proof';
            $file_name = time().' '.$request->invoice_no.' '.$request->payment_date.'.webp';

            $img = Image::make($file)
                        ->encode('webp', 80)
                        ->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream();
            $upload = Storage::put($file_path.'/'.$file_name, $img);
            $upload_path = $file_path.'/'.$file_name;
        }
        // Insert pembayaran
        if (PenjualanModel::updatePayment($request, $upload_path)) {
            return redirect('admin/penjualan/piutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function deletePembayaran(Request $request) {
        $request->validate([
            'id' => 'required|exists:tb_penjualan_invoice_bayar,id',
        ]);
        $bayar_data = PenjualanModel::getPembayaranID($request->id);
        if (PenjualanModel::deletePayment($request->id)) {
            return redirect('admin/penjualan/piutang/bayar?invoice_no='.$bayar_data->invoice_no)->withSuccess('Berhasil menghapus pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menghapus pembayaran');
        }
    }

    function getPreviousPaymentByInvNo(Request $request) {
        $response = PenjualanModel::getPreviousPayment($request->invoice_no);
        return response()->json([
            'success' => true,
            'data' => $response
        ], 200);
    }

    function deleteInvoiceItem(Request $request) {
        if (PenjualanModel::deleteInvoiceItem($request)) {
            return back()->withSuccess('Berhasil delete item');
        } else {
            return back()->withErrors('Gagal delete item');
        }
    }
    
    function deleteInvoiceItemAPI(Request $request) {
        if (PenjualanModel::deleteInvoiceItem($request)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 200);
        }
    }

    function showListPiutang() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/penjualan/piutang-list')->with($data);
    }

    function showDetailPiutang(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'items' => PenjualanModel::getInvoiceItems($request->invoice_no),
            'payments' => PenjualanModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/penjualan/piutang-detail')->with($data);
    }

    function getInvoicePiutang(Request $request) {
        $data = PenjualanModel::getInvoicePiutang($request);
        return response()->json($data, 200);
    }

    function getInvoiceLunas(Request $request) {
        $data = PenjualanModel::getInvoiceLunas($request);
        return response()->json($data, 200);
    }

    function showTransaksi() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/penjualan/transaksi')->with($data);
    }
    function showTransaksiLunas() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/penjualan/lunas-list')->with($data);
    }

    function getTransaksiFilter(Request $request) {
        $transactions = PenjualanModel::filterTransaksi($request);
        return response()->json($transactions);
    }

    function generateInvoiceNumber() {
        $number_generated = false;
        $x = 1;
        while (!$number_generated) {
            $invoice_no = "INV-CUST-".date('ym-').str_pad($x, 3, "0", STR_PAD_LEFT);
            if (PenjualanModel::getInvoice($invoice_no)) {
                $number_generated = false;
                $x++;
            } else {
                $number_generated = true;
            }
        }
        echo $invoice_no;
    }

    function showReturHome() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/penjualan/retur-home')->with($data);
    }

    function submitRetur(Request $request) {
        if (PenjualanModel::insertRetur($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan retur',
            ], 200);
        }
    }

    function getReturItems(Request $request) {
        $items = PenjualanModel::getReturnedItems($request->invoice_no);
        if (count($items) == 0) {
            $response = [
                'success' => false,
                'message' => 'No returned items'
            ];
            return response()->json($response, 400);
        }
        $response = [
            'success' => true,
            'data' => $items
        ];
        return response()->json($response, 200);
    }

    function updateInvoiceItem(Request $request) {
        if (PenjualanModel::updateInvoiceItem($request->all())) {
            $response = [
                'success' => true,
                'data' => $request->all(),
            ];
            return response()->json($response, 200);
        }
        return response()->json(['success' => false], 400);
    }

    function addInvoiceItem(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|exists:tb_product,product_code',
            'normal_price' => 'required|integer',
            'discount_rate' => 'required|numeric',
            'discounted_price' => 'required|integer',
            'qty' => 'required|integer',
            'subtotal_price' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->messages(),
            ];
            return response()->json($response, 400);
        }

        if (PenjualanModel::addInvoiceItem($request)) {
            return response()->json(['success' => true], 200);
        }
            return response()->json(['success' => false], 400);
    }

    function showReturDetail(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_penjualan,id'
        ]);

        $data = [
            'retur_data' => PenjualanModel::getReturByID($request->id),
        ];
        return view('admin.penjualan.retur-detail')->with($data);
    }

    function deleteReturItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_penjualan,id'
        ]);

        $retur_data = PenjualanModel::getReturByID($request->id);
        if (PenjualanModel::deleteReturByID($request->id)) {
            return redirect('admin/dashboard/invoice/penjualan?invoice_no='.$retur_data->invoice_no);
        } else {
            return back()->withErrors(['Failed to delete']);
        }
    }

    function printDetailPiutang(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'items' => PenjualanModel::getInvoiceItems($request->invoice_no),
            'payments' => PenjualanModel::getPreviousPayment($request->invoice_no),
            'piutang' => PenjualanModel::getPiutangByInvoice($request->invoice_no),
        ];
        $pdf = \PDF::loadView('admin/print/piutang-detail', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function showReturInvoice() {
        $data = [
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/penjualan/retur-invoice-detail')->with($data);
    }

    function updateReturItem(Request $request) {
        if (PenjualanModel::updateRetur($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan retur',
            ], 200);
        }
    }

    function deleteReturItemViaAPI(Request $request)
    {
        $retur_data = PenjualanModel::getReturByID($request->id);
        if (PenjualanModel::deleteReturByID($request->id)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 400);
        }
    }
}
