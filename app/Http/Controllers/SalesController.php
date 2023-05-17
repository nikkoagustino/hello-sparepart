<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesModel;

class SalesController extends Controller
{
    function formAddSales() {
        return view('admin/master/sales-add');
    }

    function insertSales(Request $request) {
        $request->validate([
            'sales_code' => 'required|string',
            'sales_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
        ]);

        if (SalesModel::insert($request->except('_token'))) {
            return redirect('admin/master/sales')->withSuccess('Berhasil Tambah Sales');
        } else {
            return back()->withErrors('Gagal Tambah Sales');
        }
    }

    function listSales() {
        $data = [
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/master/sales-list')->with($data);
    }

    function printSales() {
        $data = [
            'sales' => SalesModel::getAll(),
        ];
        return view('admin/print/sales')->with($data);
    }

    function detailSales(Request $request) {
        $data = [
            'sales' => SalesModel::getById($request->sales_code),
        ];
        return view('admin/master/sales-detail')->with($data);
    }

    function deleteSales(Request $request) {
        if (SalesModel::deleteSales($request->sales_code)) {
            return redirect('admin/master/sales')->withSuccess('Berhasil delete sales');
        } else {
            return back()->withErrors('Gagal delete sales');
        }
    }

    function editSales(Request $request) {
        $request->validate([
            'sales_code' => 'required|string',
            'sales_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
        ]);

        if (SalesModel::editSales($request)) {
            return redirect('admin/master/sales')->withSuccess('Berhasil Tambah Sales');
            return back()->withSuccess('Berhasil Edit Sales');
        } else {
            return back()->withErrors('Gagal Edit Sales');
        }
    }
}
