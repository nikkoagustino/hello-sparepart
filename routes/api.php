<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;

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
Route::post('verify-pin', [AccountController::class, 'verifyPIN']);
Route::get('invoice/penjualan', [PenjualanController::class, 'getInvoiceByInvNo']);
Route::get('invoice/penjualan/items', [PenjualanController::class, 'getInvoiceItemsByInvNo']);
Route::get('invoice/penjualan/payments', [PenjualanController::class, 'getPreviousPaymentByInvNo']);
Route::get('invoice/piutang', [PenjualanController::class, 'getInvoicePiutang']);
Route::get('penjualan/transaksi', [PenjualanController::class, 'getTransaksiFilter']);
Route::get('pembelian/transaksi', [PembelianController::class, 'getTransaksiFilter']);

Route::get('laporan', [LaporanController::class, 'getLaporanTransaksi']);
Route::get('laporan-tx', [LaporanController::class, 'getLaporanTransaksiV2']);

Route::get('data-laba-rugi', [LaporanController::class, 'getLabaRugi']);