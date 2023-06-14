<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductTypeModel;

class ProductController extends Controller
{
    
    function formAddProduct() {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
        ];
        return view('admin/master/product-add')->with($data);
    }

    function insertProduct(Request $request) {
        $request->validate([
            'product_code' => 'required|string',
            'product_name' => 'required|string',
            'price_capital' => 'required|integer',
            'price_selling' => 'required|integer',
            'type_code' => 'required|string',
        ]);

        if (ProductModel::insert($request->except('_token'))) {
            return redirect('admin/master/product')->withSuccess('Berhasil Tambah Produk');
        } else {
            return back()->withErrors('Gagal Tambah Produk');
        }
    }

    function listProduct() {
        $data = [
            'products' => ProductModel::getAll(),
        ];
        return view('admin/master/product-list')->with($data);
    }

    function printProduct() {
        $data = [
            'products' => ProductModel::getAll(),
        ];
        return view('admin/print/product')->with($data);
    }

    function detailProduct(Request $request) {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
            'product' => ProductModel::getById($request->product_code),
        ];
        return view('admin/master/product-detail')->with($data);
    }

    function getProductByCode(Request $request) {
        $response = ProductModel::getById($request->product_code);
        if ($response) {
            return response()->json([
                'success' => true,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No Data Available'
            ], 404);
        }
    }

    function deleteProduct(Request $request) {
        // check if any invoice
        $invoices_buy = ProductModel::getInvoicePembelianByProduct($request->product_code);
        $invoices_sell = ProductModel::getInvoicePenjualanByProduct($request->product_code);
        $errors = [];
        if (count($invoices_buy) > 0) {
            $errors[] ='Delete barang tidak diizinkan karena ada '.count($invoices_buy).' invoice pembelian pada barang ini. Delete invoice terlebih dahulu.';
        }
        if (count($invoices_sell) > 0) {
            $errors[] = 'Delete barang tidak diizinkan karena ada '.count($invoices_sell).' invoice penjualan pada barang ini. Delete invoice terlebih dahulu.';
        }
        if ($errors) {
            return redirect('admin/master/product')->withErrors($errors);
        }


        // delete barang
        if (ProductModel::deleteProduct($request->product_code)) {
            return redirect('admin/master/product')->withSuccess('Berhasil delete barang');
        } else {
            return redirect('admin/master/product')->withErrors('Gagal delete barang');
        }
    }

    function editProduct(Request $request) {
        $request->validate([
            'product_code' => 'required|string',
            'product_name' => 'required|string',
            'price_capital' => 'required|integer',
            'price_selling' => 'required|integer',
            'type_code' => 'required|string',
        ]);

        if (ProductModel::edit($request)) {
            return back()->withSuccess('Berhasil Edit Produk');
        } else {
            return back()->withErrors('Gagal Edit Produk');
        }
    }

    function showProductTx(Request $request) {
        $data = [
            'product' => ProductModel::getById($request->product_code),
            'transactions' => ProductModel::getProductTransactions($request->product_code),
            // 'laba_rugi' => ProductModel::getProductLabaRugi($request->product_code),
        ];
        return view('admin/master/product-transactions')->with($data);
    }
}
