<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    function formAddSupplier() {
        return view('admin/master/supplier-add');
    }

    function insertSupplier(Request $request) {
        $request->validate([
            'supplier_code' => 'required|string',
            'supplier_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
            'contact_person' => 'nullable|string',
        ]);

        if (SupplierModel::insert($request->except('_token'))) {
            return redirect('admin/master/supplier')->withSuccess('Berhasil Tambah Supplier');
        } else {
            return back()->withErrors('Gagal Tambah Supplier');
        }
    }

    function listSupplier() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
        ];
        return view('admin/master/supplier-list')->with($data);
    }

    function printSupplier() {
        $data = [
            'suppliers' => SupplierModel::getAll(),
        ];
        $pdf = \PDF::loadView('admin/print/supplier', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function detailSupplier(Request $request) {
        $data = [
            'supplier' => SupplierModel::getById($request->supplier_code),
        ];
        return view('admin/master/supplier-detail')->with($data);
    }

    function deleteSupplier(Request $request) {
        // check if any invoice
        $invoices = SupplierModel::getInvoiceBySupplier($request->supplier_code);
        if (count($invoices) > 0) {
            return redirect('admin/master/supplier')->withErrors('Delete supplier tidak diizinkan karena ada '.count($invoices).' invoice pada supplier ini. Delete invoice terlebih dahulu.');
        }

        // delete supplier
        if (SupplierModel::deleteSupplier($request->supplier_code)) {
            return redirect('admin/master/supplier')->withSuccess('Berhasil delete supplier');
        } else {
            return redirect('admin/master/supplier')->withErrors('Gagal delete supplier');
        }
    }

    function editSupplier(Request $request) {
        $request->validate([
            'supplier_code' => 'required|string',
            'supplier_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
            'contact_person' => 'nullable|string',
        ]);

        if (SupplierModel::edit($request)) {
            return back()->withSuccess('Berhasil Edit Supplier');
        } else {
            return back()->withErrors('Gagal Edit Supplier');
        }
    }

    function searchSupplier(Request $request) {

        $output = [
            'success' => true,
            'data' => SupplierModel::searchSupplier($request)
        ];
        return response()->json($output, 200);
    }
}