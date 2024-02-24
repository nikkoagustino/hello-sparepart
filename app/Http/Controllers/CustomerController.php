<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;

class CustomerController extends Controller
{
    function formAddCustomer() {
        return view('admin/master/customer-add');
    }

    function insertCustomer(Request $request) {
        $request->validate([
            'customer_code' => 'required|string',
            'customer_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'limit' => 'required|integer',
        ]);

        if (CustomerModel::insert($request->except('_token'))) {
            return redirect('admin/master/customer')->withSuccess('Berhasil Tambah Customer');
        } else {
            return back()->withErrors('Gagal Tambah Customer');
        }
    }

    function listCustomer() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/master/customer-list')->with($data);
    }

    function printCustomer() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/print/customer')->with($data);
    }

    function detailCustomer(Request $request) {
        $data = [
            'customer' => CustomerModel::getById($request->customer_code),
        ];
        return view('admin/master/customer-detail')->with($data);
    }

    function deleteCustomer(Request $request) {
        if (CustomerModel::deleteCustomer($request->customer_code)) {
            return redirect('admin/master/customer')->withSuccess('Berhasil delete customer');
        } else {
            return redirect('admin/master/customer')->withErrors('Gagal delete customer');
        }
    }

    function editCustomer(Request $request) {
        $request->validate([
            'customer_code' => 'required|string',
            'customer_name' => 'required|string',
            'address' => 'nullable|string',
            'phone_number_1' => 'required|string',
            'phone_number_2' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'limit' => 'required|integer',
        ]);

        if (CustomerModel::editCustomer($request)) {
            return back()->withSuccess('Berhasil Edit Customer');
        } else {
            return back()->withErrors('Gagal Edit Customer');
        }
    }

    function searchCustomer(Request $request) {
        $output = [
            'success' => true,
            'data' => CustomerModel::searchCustomer($request)
        ];
        return response()->json($output, 200);
    }
}
