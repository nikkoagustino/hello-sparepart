<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VBeltModel;
use App\Models\ProductTypeModel;

class VBeltController extends Controller
{
    function formAddVBelt() {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
        ];
        return view('admin/master/vbelt-add')->with($data);
    }

    function insertVBelt(Request $request) {
        $request->validate([
            'type_code' => 'required|string',
            'model' => 'required|string',
            'size_min' => 'required|integer',
            'size_max' => 'required|integer',
            'price' => 'required|integer',
            'price_unit' => 'required|in:PCS,INCH',
            'discount' => 'required|numeric',
        ]);

        if (VBeltModel::insert($request->except('_token'))) {
            return redirect('admin/master/vbelt')->withSuccess('Berhasil Tambah V-Belt');
        } else {
            return back()->withErrors('Gagal Tambah V-Belt');
        }
    }

    function listVBelt() {
        $data = [
            'vbelts' => VBeltModel::getAll(),
        ];
        return view('admin/master/vbelt-list')->with($data);
    }

    function printVBelt() {
        $data = [
            'vbelts' => VBeltModel::getAll(),
        ];
        $pdf = \PDF::loadView('admin/print/vbelt', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function detailVBelt(Request $request) {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
            'vbelt' => VBeltModel::getById($request->id),
        ];
        return view('admin/master/vbelt-detail')->with($data);
    }

    function deleteVBelt(Request $request) {
        // Check invoice

        // delete barang
        if (VBeltModel::deleteVBelt($request->id)) {
            return redirect('admin/master/vbelt')->withSuccess('Berhasil delete V-Belt');
        } else {
            return redirect('admin/master/vbelt')->withErrors('Gagal delete V-Belt');
        }
    }

    function editVBelt(Request $request) {
        $request->validate([
            'id' => 'required|integer',
            'type_code' => 'required|string',
            'model' => 'required|string',
            'size_min' => 'required|integer',
            'size_max' => 'required|integer',
            'price' => 'required|integer',
            'price_unit' => 'required|in:PCS,INCH',
            'discount' => 'required|numeric',
        ]);

        if (VBeltModel::editVBelt($request)) {
            return back()->withSuccess('Berhasil Edit V-Belt');
        } else {
            return back()->withErrors('Gagal Edit V-Belt');
        }
    }

    function searchVBelt(Request $request) {

        $output = [
            'success' => true,
            'data' => VBeltModel::searchVBelt($request)
        ];
        return response()->json($output, 200);
    }
}
