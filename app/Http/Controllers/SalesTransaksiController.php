<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SalesTransaksiModel;
use App\Models\SalesModel;

class SalesTransaksiController extends Controller
{
    public function getSalesTransaction(Request $request) {
        $validator = Validator::make($request->all(), [
            'sales_code' => 'nullable|string',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tx = SalesTransaksiModel::getTransaksiSales($request);
        return response()->json($tx, 200);
    }

    public function showTransactionForm() {
        $data = [
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/account/sales-transaksi')->with($data);
    }

    public function showNewTransactionForm(Request $request) {
        $data = [
            'sales' => SalesModel::getById($request->sales_code),
        ];
        return view('admin/account/sales-transaksi-new')->with($data);
    }

    public function submitNewTransaction(Request $request) {
        $request->validate([
            'sales_code' => 'required|string',
            'tx_date' => 'required|date',
            'amount' => 'required|integer',
            'description' => 'required|string',
        ]);

        if (SalesTransaksiModel::insertTx($request)) {
            return redirect('admin/account/sales/transaksi')->withSuccess('Berhasil menyimpan transaksi');
        } else {
            return back()->withErrors('Gagal menyimpan transaksi');
        }
    }

    public function showEditForm(Request $request) {
        $data = [
            'tx_data' => SalesTransaksiModel::getTxById($request->id),
        ];
        return view('admin/account/sales-transaksi-edit')->with($data);
    }

    public function submitEditForm(Request $request) {
        $request->validate([
            'id' => 'required|integer',
            'tx_date' => 'required|date',
            'amount' => 'required|integer',
            'description' => 'required|string',
        ]);

        if (SalesTransaksiModel::updateTx($request)) {
            return redirect('admin/account/sales/transaksi')->withSuccess('Berhasil menyimpan transaksi');
        } else {
            return back()->withErrors('Gagal menyimpan transaksi');
        }
    }
}
