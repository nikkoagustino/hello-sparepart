<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianModel;
use App\Models\PenjualanModel;
use App\Models\CustomerModel;
use App\Models\SalesModel;
use App\Models\SupplierModel;
use App\Models\ProductModel;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class DashboardController extends Controller
{
    function showListHutang() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
        ];
        return view('admin/dashboard/hutang-list')->with($data);
    }

    function showPembayaranHutang(Request $request) {
        $data = [
            'invoice' => PembelianModel::getInvoiceDetail($request->invoice_no),
            'payments' => PembelianModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/dashboard/hutang-bayar')->with($data);
    }

    function savePembayaranHutang(Request $request) {
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
            return redirect('admin/dashboard/hutang/bayar?invoice_no='.$request->invoice_no)->withSuccess('Berhasil menyimpan pembayaran');
        } else {
            return redirect()->back()->withErrors('Gagal menyimpan pembayaran');
        }
    }

    function showListPiutang() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/dashboard/piutang-list')->with($data);
    }

    function showPembayaranPiutang(Request $request) {
        $data = [
            'invoice' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'payments' => PenjualanModel::getPreviousPayment($request->invoice_no),
        ];
        return view('admin/dashboard/piutang-bayar')->with($data);
    }

    function savePembayaranPiutang(Request $request) {
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

    function showInvoicePenjualanDetail() {
        $data = [
            'invoices' => PenjualanModel::getAllInvoice(),
            'customers' => CustomerModel::getAll(),
            'sales' => SalesModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/dashboard/penjualan-invoice-detail')->with($data);
    }

    function showPenjualanReturDetail(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_penjualan,id'
        ]);

        $data = [
            'retur_data' => PenjualanModel::getReturByID($request->id),
        ];
        return view('admin/dashboard/penjualan-retur-detail')->with($data);
    }

    function deletePenjualanReturItem(Request $request)
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




    function showInvoicePembelianDetail() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
            'products' => ProductModel::getAll(),
        ];
        return view('admin/dashboard/pembelian-invoice-detail')->with($data);
    }

    function showInvoicePembelianList() {
        $data = [
            'invoices' => PembelianModel::getAllInvoice(),
            'suppliers' => SupplierModel::getAll()
        ];
        return view('admin/dashboard/pembelian-invoice-list')->with($data);
    }

    function showPembelianReturDetail(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tb_retur_pembelian,id'
        ]);

        $data = [
            'retur_data' => PembelianModel::getReturByID($request->id),
        ];
        return view('admin/dashboard/pembelian-retur-detail')->with($data);
    }

    function deletePembelianReturItem(Request $request)
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

    function deleteInvoicePembelian(Request $request)
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
