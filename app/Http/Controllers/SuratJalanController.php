<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Validator;

class SuratJalanController extends Controller
{
    public function showSuratJalanForm()
    {
        return view('admin/dashboard/surat-jalan');
    }

    public function printSuratJalan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_no' => 'required|exists:tb_penjualan_invoice_master,invoice_no',
            'tgl_kirim' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = [
            'master' => PenjualanModel::getInvoiceDetail($request->invoice_no),
            'items' => PenjualanModel::getInvoiceItems($request->invoice_no),
        ];
        $pdf = \PDF::loadView('admin/print/surat-jalan', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }
}
