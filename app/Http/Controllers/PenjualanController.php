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
            'invoice_no' => 'required|regex:/^[a-zA-Z0-9_\.\-\/]+$/',
            'customer_code' => 'required|string',
            'sales_code' => 'required|string',
            'invoice_date' => 'required|date',
            'days_expire' => 'required|integer',
            'description' => 'nullable|string',
            'payment_type' => 'required|string',

            'product_code' => 'required|string',
            'normal_price' => 'required|string',
            'discount_rate' => 'required|string',
            'qty' => 'required|string',
        ]);

        // Check if invoice number exists, if not exist create new
        if (!PenjualanModel::getInvoice($request->invoice_no)) {
            PenjualanModel::createInvoice($request);
        }

        // Insert invoice data
        if (PenjualanModel::addInvoiceItem($request)) {
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
            'invoices' => PenjualanModel::getAllInvoice(),
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/penjualan/invoice-detail')->with($data);
    }

    function showInvoiceList() {
        $data = [
            'invoices' => PenjualanModel::getAllInvoice(),
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
        return view('admin/print/invoice-sell-list')->with($data);
    }

    function printInvoice(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'items' => PenjualanModel::getInvoiceItems($request->invoice_no),
            'retur' => PenjualanModel::getReturnedItems($request->invoice_no)
        ];
        return view('admin/print/invoice-sell')->with($data);
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
        return view('admin/penjualan/invoice-payment-show')->with($data);
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
            return redirect('admin/dashboard/piutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
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

    function showListPiutang() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/penjualan/piutang-list')->with($data);
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
            'invoices' => PenjualanModel::getAllReturInvoice(),
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
}
