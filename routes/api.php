<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesTransaksiController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VBeltController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product', [ProductController::class, 'getProductByCode']);

Route::get('invoice/pembelian', [PembelianController::class, 'getInvoiceByInvNo']);
Route::get('invoice/pembelian/items', [PembelianController::class, 'getInvoiceItemsByInvNo']);
Route::get('invoice/pembelian/payments', [PembelianController::class, 'getPreviousPaymentByInvNo']);
Route::get('invoice/hutang', [PembelianController::class, 'getInvoiceTerhutang']);
Route::get('pembelian/transaksi', [PembelianController::class, 'getTransaksiFilter']);
Route::get('invoice/pembelian/lunas', [PembelianController::class, 'getInvoiceLunas']);
Route::post('pembelian/retur', [PembelianController::class, 'submitRetur']);
Route::get('pembelian/retur/items', [PembelianController::class, 'getReturItems']);
Route::post('pembelian/retur/update', [PembelianController::class, 'updateReturItem']);
Route::get('pembelian/retur/delete', [PembelianController::class, 'deleteReturItemViaAPI']);
Route::get('pembelian/transaksi', [PembelianController::class, 'getTransaksiFilter']);

Route::post('pembelian/add-item', [PembelianController::class, 'addInvoiceItem']);
Route::post('pembelian/edit-item', [PembelianController::class, 'updateInvoiceItem']);
Route::get('pembelian/delete-item', [PembelianController::class, 'deleteInvoiceItemAPI']);

Route::post('verify-pin', [AccountController::class, 'verifyPIN']);

Route::get('invoice/penjualan', [PenjualanController::class, 'getInvoiceByInvNo']);
Route::get('invoice/penjualan/items', [PenjualanController::class, 'getInvoiceItemsByInvNo']);
Route::get('invoice/penjualan/payments', [PenjualanController::class, 'getPreviousPaymentByInvNo']);
Route::get('invoice/piutang', [PenjualanController::class, 'getInvoicePiutang']);
Route::get('penjualan/transaksi', [PenjualanController::class, 'getTransaksiFilter']);
Route::get('invoice/penjualan/lunas', [PenjualanController::class, 'getInvoiceLunas']);
Route::post('penjualan/retur', [PenjualanController::class, 'submitRetur']);
Route::get('penjualan/retur/items', [PenjualanController::class, 'getReturItems']);
Route::post('penjualan/retur/update', [PenjualanController::class, 'updateReturItem']);
Route::get('penjualan/retur/delete', [PenjualanController::class, 'deleteReturItemViaAPI']);

Route::post('penjualan/add-item', [PenjualanController::class, 'addInvoiceItem']);
Route::post('penjualan/edit-item', [PenjualanController::class, 'updateInvoiceItem']);
Route::get('penjualan/delete-item', [PenjualanController::class, 'deleteInvoiceItemAPI']);

Route::get('laporan', [LaporanController::class, 'getLaporanTransaksi']);
Route::get('laporan-tx', [LaporanController::class, 'getLaporanTransaksiV2']);
Route::get('laporan-bulanan', [LaporanController::class, 'getLaporanBulanan']);
Route::get('laporan/product', [LaporanController::class, 'getLaporanProduct']);
Route::get('laporan/product-type', [LaporanController::class, 'getLaporanProductType']);
Route::get('laporan/rekap-produk', [LaporanController::class, 'getRekapProduk']);
Route::get('laporan/rekap-jenis-barang', [LaporanController::class, 'getRekapJenisBarang']);
Route::get('laporan/rekap-customer', [LaporanController::class, 'getRekapCustomer']);

Route::get('dashboard-laba-rugi', [LaporanController::class, 'getDashboardLabaRugi']);
// Route::get('data-laba-rugi', [LaporanController::class, 'getLabaRugi']);
// Route::get('invoice/pembelian/generate', [PembelianController::class, 'generateInvoiceNumber']);
// Route::get('invoice/penjualan/generate', [PenjualanController::class, 'generateInvoiceNumber']);

Route::get('komisi', [KomisiController::class, 'getKomisiViewTable']);
Route::post('komisi/save', [KomisiController::class, 'updateKomisi']);
Route::get('transaksi', [SalesTransaksiController::class, 'getSalesTransaction']);
Route::post('transaksi/save', [SalesTransaksiController::class, 'insertTx']);

Route::get('customer-search', [CustomerController::class, 'searchCustomer']);
Route::get('product-type-search', [ProductTypeController::class, 'searchProductType']);
Route::get('product-search', [ProductController::class, 'searchProduct']);
Route::get('sales-search', [SalesController::class, 'searchSales']);
Route::get('supplier-search', [SupplierController::class, 'searchSupplier']);
Route::get('vbelt-search', [VBeltController::class, 'searchVBelt']);