<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use App\Models\PembelianModel;
use App\Models\ProductModel;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class PembelianController extends Controller
{
    function showInvoiceHome() {
        return view('admin/pembelian/invoice-home');
    }

    function formNewInvoice() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/invoice-new')->with($data);
    }

    function createInvoice(Request $request) {
        $request->validate([
            'invoice_no' => 'required|regex:/^[a-zA-Z0-9_\.\-]+$/',
            'supplier_code' => 'required|string',
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
        if (!PembelianModel::getInvoice($request->invoice_no)) {
            PembelianModel::createInvoice($request);
        }

        // Insert invoice data
        if (PembelianModel::addInvoiceItem($request)) {
            return redirect('admin/pembelian/invoice')->withSuccess('Berhasil membuat invoice');
        } else {
            return redirect()->back()->withErrors('Gagal membuat invoice');
        }

    }

    function getInvoiceByInvNo(Request $request) {
        $response = PembelianModel::getInvoiceDetail($request->invoice_no);
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
        $response = PembelianModel::getInvoiceItems($request->invoice_no);
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
        return view('admin/pembelian/invoice-detail');
    }

    function showInvoiceList() {
        $data = [
            'invoices' => PembelianModel::getAllInvoice(),
        ];
        return view('admin/pembelian/invoice-list')->with($data);
    }

    function printInvoice(Request $request) {
        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'items' => PembelianModel::getInvoiceItems($request->invoice_no),
        ];
        return view('admin/print/invoice')->with($data);
    }

    function showPembayaranHome() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
        ];
        return view('admin/pembelian/invoice-payment')->with($data);
    }

    function showPembayaranInvoice(Request $request) {
        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'payments' => PembelianModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/pembelian/invoice-payment-show')->with($data);
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
            $file_path = 'pembelian_payment_proof';
            $file_name = time().' '.$request->invoice_no.' '.$request->payment_date.'.webp';

            $img = Image::make($file)
                        ->encode('webp', 80)
                        ->fit(800, 800)
                        ->stream();
            $upload = Storage::put($file_path.'/'.$file_name, $img);
            $upload_path = $file_path.'/'.$file_name;
        }

        // Insert pembayaran
        if (PembelianModel::insertPayment($request, $upload_path)) {
            return redirect('admin/pembelian/pembayaran/invoice/'.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function getPreviousPaymentByInvNo(Request $request) {
        $response = PembelianModel::getPreviousPayment($request->invoice_no);
        return response()->json([
            'success' => true,
            'data' => $response
        ], 200);
    }

    function deleteInvoiceItem(Request $request) {
        if (PembelianModel::deleteInvoiceItem($request)) {
            return back()->withSuccess('Berhasil delete item');
        } else {
            return back()->withErrors('Gagal delete item');
        }
    }

    function showListHutang() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
        ];
        return view('admin/pembelian/hutang-list')->with($data);
    }

    function getInvoiceTerhutang(Request $request) {
        $data = PembelianModel::getInvoiceTerhutang($request);
        return response()->json($data, 200);
    }

    function showTransaksi() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/transaksi')->with($data);
    }

    function getTransaksiFilter(Request $request) {
        $transactions = PembelianModel::filterTransaksi($request);
        return response()->json($transactions);
    }
}
