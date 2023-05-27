<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\KomisiModel;

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
}
