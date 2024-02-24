<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTypeModel;

class ProductTypeController extends Controller
{
    function formAddProductType() {
        return view('admin/master/product-type-add');
    }

    function insertProductType(Request $request) {
        $request->validate([
            'type_code' => 'required|unique:tb_product_type,type_code',
            'type_name' => 'required|string',
        ]);

        if (ProductTypeModel::insert($request->except('_token'))) {
            return redirect('admin/master/product-type')->withSuccess('Berhasil Tambah Tipe Produk');
        } else {
            return back()->withErrors('Gagal Tambah Tipe Produk');
        }
    }

    function listProductType() {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
        ];
        return view('admin/master/product-type-list')->with($data);
    }

    function printProductType() {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
        ];
        $pdf = \PDF::loadView('admin/print/product-type', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function detailProductType(Request $request) {
        $data = [
            'product_type' => ProductTypeModel::getById($request->type_code),
        ];
        return view('admin/master/product-type-detail')->with($data);
    }

    function deleteProductType(Request $request) {
        // check if any product
        $products = ProductTypeModel::getProductByTypeCode($request->type_code);
        $vbelts = ProductTypeModel::getVBeltByTypeCode($request->type_code);
        $errors = [];
        if (count($products) > 0) {
            $errors[] = 'Delete jenis barang tidak diizinkan karena ada '.count($products).' produk pada jenis ini. Delete produk terlebih dahulu.';
        }
        if (count($vbelts) > 0) {
            $errors[] = 'Delete jenis barang tidak diizinkan karena ada '.count($vbelts).' V-Belt pada jenis ini. Delete V-Belt terlebih dahulu.';
        }
        if ($errors) {
            return redirect('admin/master/product-type')->withErrors($errors);
        }

        // delete jenis barang
        if (ProductTypeModel::deleteProductType($request->type_code)) {
            return redirect('admin/master/product-type')->withSuccess('Berhasil delete jenis barang');
        } else {
            return redirect('admin/master/product-type')->withErrors('Gagal delete jenis barang');
        }
    }

    function editProductType(Request $request) {
        $request->validate([
            'type_code' => 'required|string',
            'type_name' => 'required|string',
        ]);

        if (ProductTypeModel::edit($request)) {
            return back()->withSuccess('Berhasil Edit Tipe Produk');
        } else {
            return back()->withErrors('Gagal Edit Tipe Produk');
        }
    }

    function searchProductType(Request $request) {
        $output = [
            'success' => true,
            'data' => ProductTypeModel::searchProductType($request)
        ];
        return response()->json($output, 200);
    }
}
