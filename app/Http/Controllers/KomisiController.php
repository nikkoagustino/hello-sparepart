<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\KomisiModel;
use App\Models\SalesModel;

class KomisiController extends Controller
{
    public function getKomisiViewTable(Request $request) {
        $validator = Validator::make($request->all(), [
            'sales_code' => 'required|string',
            'year' => 'required|integer',
            'month' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = [
            'invoices' => KomisiModel::getSalesInvoice($request),
            'percent_komisi' => KomisiModel::getPercentKomisi($request),
        ];
        return response()->json($data, 200);
    }

    public function updateKomisi(Request $request) {
        $validator = Validator::make($request->all(), [
            'sales_code' => 'required|string',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'persen_komisi' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (KomisiModel::upsertKomisi($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil update komisi',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update komisi',
            ], 400);
        }
    }

    public function showKomisiForm() {
        $data = [
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/account/sales-komisi')->with($data);
    }
}
