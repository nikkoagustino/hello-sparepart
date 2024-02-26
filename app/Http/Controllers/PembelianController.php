<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use App\Models\PembelianModel;
use App\Models\ProductModel;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Str;

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
            'invoice_no' => 'required|unique:tb_pembelian_invoice_master,invoice_no|regex:/^[a-zA-Z0-9_\.\-\/]+$/',
            'supplier_code' => 'required|string',
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

        $master_add = PembelianModel::createInvoice($request);

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
            $item_add = PembelianModel::addInvoiceItem($data);
        }
        if ($master_add) {
            $request->session()->flash('is_print', (int) $request->is_print);
            $request->session()->flash('invoice_no', $request->invoice_no);
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

    function showDetailHutang(Request $request) {
        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'items' => PembelianModel::getInvoiceItems($request->invoice_no),
            'payments' => PembelianModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/pembelian/hutang-detail')->with($data);
    }

    function printDetailHutang(Request $request) {

        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'items' => PembelianModel::getInvoiceItems($request->invoice_no),
            'payments' => PembelianModel::getPreviousPayment($request->invoice_no),
            'hutang' => PembelianModel::getHutangByInvoice($request->invoice_no),
        ];
        $pdf = \PDF::loadView('admin/print/hutang-detail', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function showInvoiceDetail() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/invoice-detail')->with($data);
    }

    function showDetailTransaksi() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/transaksi-detail')->with($data);
    }

    function showReturInvoice() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/retur-invoice-detail')->with($data);
    }

    function showInvoiceList() {
        $data = [
            'invoices' => PembelianModel::getAllInvoice(),
            'suppliers' => SupplierModel::getAll()
        ];
        return view('admin/pembelian/invoice-list')->with($data);
    }

    function printInvoiceList() {
        $data = [
            'invoices' => PembelianModel::getAllInvoice(),
        ];
        return view('admin/print/invoice-buy-list')->with($data);
    }

    function printInvoiceLunas() {
        $data = [
            'invoices' => PembelianModel::getInvoiceLunas(),
        ];
        return view('admin/print/invoice-buy-list')->with($data);
    }

    // function printInvoiceHutang() {
    //     $data = [
    //         'invoices' => PembelianModel::getInvoiceTerhutang(),
    //     ];
    //     return view('admin/print/invoice-buy-list')->with($data);
    // }

    function printInvoiceRetur() {
        $data = [
            'invoices' => PembelianModel::getAllReturInvoice(),
        ];
        return view('admin/print/invoice-buy-list')->with($data);
    }

    function printInvoice(Request $request) {
        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'items' => PembelianModel::getInvoiceItems($request->invoice_no),
            'retur' => PembelianModel::getReturnedItems($request->invoice_no),
        ];
        $pdf = \PDF::loadView('admin/print/invoice-buy', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
        // return view('admin/print/invoice-buy')->with($data);
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
        return view('admin/pembelian/hutang-bayar')->with($data);
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
                        ->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream();
            $upload = Storage::put($file_path.'/'.$file_name, $img);
            $upload_path = $file_path.'/'.$file_name;
        }

        // Insert pembayaran
        if (PembelianModel::insertPayment($request, $upload_path)) {
            if (Str::contains($request->redirect_to, 'dashboard')) {
                return redirect('admin/dashboard/hutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
            } else {
                return redirect('admin/pembelian/hutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
            }
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function editPembayaran(Request $request) {
        $request->validate([
            'edit_id' => 'required|exists:tb_pembelian_invoice_bayar,id',
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
        if (PembelianModel::updatePayment($request, $upload_path)) {
            return redirect('admin/pembelian/hutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function deletePembayaran(Request $request) {
        $request->validate([
            'id' => 'required|exists:tb_pembelian_invoice_bayar,id',
        ]);
        $bayar_data = PembelianModel::getPembayaranID($request->id);
        if (PembelianModel::deletePayment($request->id)) {
            return redirect('admin/pembelian/hutang/bayar?invoice_no='.$bayar_data->invoice_no)->withSuccess('Berhasil menghapus pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menghapus pembayaran');
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

    function printInvoiceHutang(Request $request) {
        $data = [
            'invoices' => PembelianModel::getInvoiceTerhutang($request)
        ];

        $pdf = \PDF::loadView('admin/print/invoice-buy-list', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    //     return view('admin/print/invoice-buy-list')->with($data);
    }

    function getInvoiceLunas(Request $request) {
        $data = PembelianModel::getInvoiceLunas($request);
        return response()->json($data, 200);
    }

    function showTransaksi() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/transaksi')->with($data);
    }

    function showTransaksiLunas() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/pembelian/lunas-list')->with($data);
    }

    function getTransaksiFilter(Request $request) {
        $transactions = PembelianModel::filterTransaksi($request);
        return response()->json($transactions);
    }

    function printTransaksi(Request $request) {
        $data = [
            'invoices' => PembelianModel::filterTransaksi($request)
        ];
        $pdf = \PDF::loadView('admin/print/transaksi-pembelian', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function generateInvoiceNumber() {
        $number_generated = false;
        $x = 1;
        while (!$number_generated) {
            $invoice_no = "INV-SUPP-".date('ym-').str_pad($x, 3, "0", STR_PAD_LEFT);
            if (PembelianModel::getInvoice($invoice_no)) {
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
            'suppliers' => SupplierModel::getAll(),
        ];
        return view('admin/pembelian/retur-home')->with($data);
    }

    function submitRetur(Request $request) {
        if (PembelianModel::insertRetur($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan retur',
            ], 200);
        }
    }

    function updateReturItem(Request $request) {
        if (PembelianModel::updateRetur($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan retur',
            ], 200);
        }
    }

    function getReturItems(Request $request) {
        $items = PembelianModel::getReturnedItems($request->invoice_no);
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
        if (PembelianModel::updateInvoiceItem($request->all())) {
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

        if (PembelianModel::addInvoiceItem($request)) {
            return response()->json(['success' => true], 200);
        }
            return response()->json(['success' => false], 400);
    }

    function deleteInvoiceItemAPI(Request $request) {
        if (PembelianModel::deleteInvoiceItem($request)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 200);
        }
    }

    function showReturDetail(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_pembelian,id'
        ]);

        $data = [
            'retur_data' => PembelianModel::getReturByID($request->id),
        ];
        return view('admin.pembelian.retur-detail')->with($data);
    }

    function deleteReturItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_pembelian,id'
        ]);

        $retur_data = PembelianModel::getReturByID($request->id);
        if (PembelianModel::deleteReturByID($request->id)) {
            return redirect('admin/dashboard/invoice/pembelian/detail?invoice_no='.$retur_data->invoice_no);
        } else {
            return back()->withErrors(['Failed to delete']);
        }
    }

    function deleteReturItemViaAPI(Request $request)
    {
        $retur_data = PembelianModel::getReturByID($request->id);
        if (PembelianModel::deleteReturByID($request->id)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 400);
        }
    }

    function deleteInvoice(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|exists:tb_pembelian_invoice_master,invoice_no'
        ]);

        if (PembelianModel::deleteInvoice($request->invoice_no)) {
            return redirect('admin/dashboard/invoice/pembelian')->withSuccess('Invoice berhasil dihapus');
        }
        return back()->withErrors(['Gagal menghapus invoice']);
    }
}
