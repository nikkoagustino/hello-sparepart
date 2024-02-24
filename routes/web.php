<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VBeltController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\SalesTransaksiController;
use App\Http\Controllers\SuratJalanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('admin/dashboard');
});

Route::prefix('admin')->group(function(){
    Route::prefix('login')->group(function(){
        Route::get('/', [AccountController::class, 'formLogin']);
        Route::post('/', [AccountController::class, 'submitLogin']);
        Route::get('otp', [AccountController::class, 'showOTPForm']);
        Route::post('otp', [AccountController::class, 'verifyOTP']);
    });
});

Route::prefix('admin')->middleware('session.check')->group(function(){
    Route::prefix('account')->group(function(){
        Route::get('/', function() {
            return view('admin.account.home');
        });
        Route::prefix('sales')->group(function(){
            Route::get('/', function(){
                return view('admin.account.sales-home');
            });

            Route::get('komisi', [KomisiController::class, 'showKomisiForm']);

            Route::prefix('transaksi')->group(function() {
                Route::get('/', [SalesTransaksiController::class, 'showTransactionForm']);
                Route::get('new', [SalesTransaksiController::class, 'showNewTransactionForm']);
                Route::post('new', [SalesTransaksiController::class, 'submitNewTransaction']);
                Route::get('detail/{id}', [SalesTransaksiController::class, 'showEditForm']);
                Route::post('edit', [SalesTransaksiController::class, 'submitEditForm']);
            });
        });

        Route::prefix('admin')->group(function(){
            Route::get('/', [AccountController::class, 'showAccount']);
            Route::get('add', [AccountController::class, 'showAddAccountForm']);
            Route::post('add', [AccountController::class, 'createAccount']);
            Route::get('detail/{id}', [AccountController::class, 'showAdminDetail']);
            Route::post('edit', [AccountController::class, 'submitEditAdmin']);
            Route::get('delete/{username}', [AccountController::class, 'deleteAdmin']);
        });

        Route::get('absen', [AbsensiController::class, 'getAbsen']);
        Route::post('absen', [AbsensiController::class, 'insertAbsen']);

        Route::get('2fa-setup', [AccountController::class, 'show2FASetup']);
        Route::post('2fa-setup', [AccountController::class, 'submit2FASetup']);

        Route::get('2fa-remove', [AccountController::class, 'remove2FA']);
    });


    Route::get('logout', [AccountController::class, 'logout']);

    Route::prefix('dashboard')->group(function() {
        Route::get('/', function() {
            return view('admin.dashboard.home');
        });
        Route::get('invoice', function(){
            return view('admin.dashboard.invoice-home');
        });

        Route::prefix('hutang')->group(function(){
            Route::get('/', [PembelianController::class, 'showListHutang']);
            Route::get('detail', [PembelianController::class, 'showDetailHutang']);
            Route::get('bayar', [PembelianController::class, 'showPembayaranInvoice']);
            Route::post('bayar', [PembelianController::class, 'savePembayaran']);
        });

        Route::prefix('piutang')->group(function(){
            Route::get('/', [PenjualanController::class, 'showListPiutang']);
            Route::get('detail', [PenjualanController::class, 'showDetailPiutang']);
            Route::get('bayar', [PenjualanController::class, 'showPembayaranInvoice']);
            Route::post('bayar', [PenjualanController::class, 'savePembayaran']);
        });

        Route::prefix('surat-jalan')->group(function(){
            Route::get('/', [SuratJalanController::class, 'showSuratJalanForm']);
        });

        Route::prefix('invoice')->group(function(){
            Route::get('penjualan', [PenjualanController::class, 'showInvoiceDetail']);
            Route::get('penjualan/retur', [PenjualanController::class, 'showReturDetail']);
            Route::get('penjualan/retur/delete', [PenjualanController::class, 'deleteReturItem']);

            Route::get('pembelian', [PembelianController::class, 'showInvoiceList']);
            Route::get('pembelian/detail', [PembelianController::class, 'showInvoiceDetail']);
            Route::get('pembelian/retur', [PembelianController::class, 'showReturDetail']);
            Route::get('pembelian/delete', [PembelianController::class, 'deleteInvoice']);
            Route::get('pembelian/retur/delete', [PembelianController::class, 'deleteReturItem']);

        });

        Route::get('laba-rugi', [LaporanController::class, 'showDashboardLabaRugi']);
    });

    Route::prefix('master')->group(function(){
        Route::get('/', function(){
            return view('admin.master.home');
        });

        Route::prefix('customer')->group(function(){
            Route::get('/', [CustomerController::class, 'listCustomer']);

            Route::get('detail/{customer_code}', [CustomerController::class, 'detailCustomer']);

            Route::get('add', [CustomerController::class, 'formAddCustomer']);
            Route::post('add', [CustomerController::class, 'insertCustomer']);
            Route::get('delete/{customer_code}', [CustomerController::class, 'deleteCustomer']);
            Route::post('edit', [CustomerController::class, 'editCustomer']);
        });

        Route::prefix('supplier')->group(function(){
            Route::get('/', [SupplierController::class, 'listSupplier']);

            Route::get('detail/{supplier_code}', [SupplierController::class, 'detailSupplier']);

            Route::get('add', [SupplierController::class, 'formAddSupplier']);
            Route::post('add', [SupplierController::class, 'insertSupplier']);
            Route::get('delete/{supplier_code}', [SupplierController::class, 'deleteSupplier']);
            Route::post('edit', [SupplierController::class, 'editSupplier']);
        });

        Route::prefix('sales')->group(function(){
            Route::get('/', [SalesController::class, 'listSales']);

            Route::get('detail/{sales_code}', [SalesController::class, 'detailSales']);

            Route::get('add', [SalesController::class, 'formAddSales']);
            Route::post('add', [SalesController::class, 'insertSales']);
            Route::get('delete/{sales_code}', [SalesController::class, 'deleteSales']);
            Route::post('edit', [SalesController::class, 'editSales']);
        });

        Route::prefix('product-type')->group(function(){
            Route::get('/', [ProductTypeController::class, 'listProductType']);

            Route::get('detail/{type_code}', [ProductTypeController::class, 'detailProductType']);

            Route::get('add', [ProductTypeController::class, 'formAddProductType']);
            Route::post('add', [ProductTypeController::class, 'insertProductType']);
            Route::get('delete/{type_code}', [ProductTypeController::class, 'deleteProductType']);
            Route::post('edit', [ProductTypeController::class, 'editProductType']);
        });

        Route::prefix('product')->group(function(){
            Route::get('/', [ProductController::class, 'listProduct']);

            Route::get('detail/{product_code}', [ProductController::class, 'detailProduct']);

            Route::get('add', [ProductController::class, 'formAddProduct']);
            Route::post('add', [ProductController::class, 'insertProduct']);
            Route::get('delete/{product_code}', [ProductController::class, 'deleteProduct']);
            Route::post('edit', [ProductController::class, 'editProduct']);
            Route::get('transaksi/{product_code}', [ProductController::class, 'showProductTx']);
            Route::get('export', [ProductController::class, 'exportCSV']);
        });

        Route::prefix('vbelt')->group(function(){
            Route::get('/', [VBeltController::class, 'listVBelt']);

            Route::get('detail/{id}', [VBeltController::class, 'detailVBelt']);

            Route::get('add', [VBeltController::class, 'formAddVBelt']);
            Route::post('add', [VBeltController::class, 'insertVBelt']);
            Route::get('delete/{id}', [VBeltController::class, 'deleteVBelt']);
            Route::post('edit', [VBeltController::class, 'editVBelt']);
        });
    });

    Route::prefix('print')->group(function(){
        Route::get('absen', [AbsensiController::class, 'printAbsensi']);
        Route::get('customer', [CustomerController::class, 'printCustomer']);
        Route::get('supplier', [SupplierController::class, 'printSupplier']);
        Route::get('sales', [SalesController::class, 'printSales']);
        Route::get('komisi-sales', [KomisiController::class, 'printKomisiSales']);
        Route::get('transaksi-sales', [SalesTransaksiController::class, 'printTransaksiSales']);
        Route::get('product-type', [ProductTypeController::class, 'printProductType']);
        Route::get('product', [ProductController::class, 'printProduct']);
        Route::get('vbelt', [VBeltController::class, 'printVBelt']);
        Route::get('invoice-buy', [PembelianController::class, 'printInvoice']);
        Route::get('invoice-sell', [PenjualanController::class, 'printInvoice']);
        Route::get('invoice-buy-list', [PembelianController::class, 'printInvoiceList']);
        Route::get('invoice-sell-list', [PenjualanController::class, 'printInvoiceList']);
        Route::get('buy-retur-list', [PembelianController::class, 'printInvoiceRetur']);
        Route::get('sell-retur-list', [PenjualanController::class, 'printInvoiceRetur']);
        Route::get('buy-lunas-list', [PembelianController::class, 'printInvoiceLunas']);
        Route::get('sell-lunas-list', [PenjualanController::class, 'printInvoiceLunas']);
        Route::get('buy-hutang-list', [PembelianController::class, 'printInvoiceHutang']);
        Route::get('sell-piutang-list', [PenjualanController::class, 'printInvoicePiutang']);
        Route::get('laba-rugi-tahun/{year}', [LaporanController::class, 'printLabaRugiTahunan']);
        Route::get('laba-rugi-bulanan', [LaporanController::class, 'printLabaRugiBulanan']);
        Route::get('laporan-pembelian', [LaporanController::class, 'printLaporanPembelian']);
        Route::get('laporan-penjualan', [LaporanController::class, 'printLaporanPenjualan']);
        Route::get('product/tx', [LaporanController::class, 'printProductTx']);
        Route::get('surat-jalan', [SuratJalanController::class, 'printSuratJalan']);
        Route::get('rangkuman-laba-rugi', [LaporanController::class, 'printRangkumanLabaRugi']);
    });

    Route::prefix('pembelian')->group(function(){
        Route::get('/', function(){
            return view('admin.pembelian.home');
        });

        Route::prefix('invoice')->group(function(){
            Route::get('/', [PembelianController::class, 'showInvoiceHome']);
            Route::get('new', [PembelianController::class, 'formNewInvoice']);
            Route::post('new', [PembelianController::class, 'createInvoice']);
            Route::get('detail', [PembelianController::class, 'showInvoiceDetail']);
            Route::get('list', [PembelianController::class, 'showInvoiceList']);
            Route::get('delete-item', [PembelianController::class, 'deleteInvoiceItem']);
        });

        // Route::prefix('pembayaran')->group(function(){
        //     Route::get('/', [PembelianController::class, 'showPembayaranHome']);
        //     Route::get('invoice', [PembelianController::class, 'showPembayaranInvoice']);
        //     Route::post('add', [PembelianController::class, 'savePembayaran']);
        // });

        Route::prefix('transaksi')->group(function(){
            Route::get('/', [PembelianController::class, 'showTransaksi']);
        });

        Route::prefix('lunas')->group(function(){
            Route::get('/', [PembelianController::class, 'showTransaksiLunas']);
        });

        Route::prefix('retur')->group(function(){
            Route::get('/', [PembelianController::class, 'showReturHome']);
        });
    });

    Route::prefix('penjualan')->group(function(){
        Route::get('/', function(){
            return view('admin.penjualan.home');
        });

        Route::prefix('invoice')->group(function(){
            Route::get('/', [PenjualanController::class, 'showInvoiceHome']);
            Route::get('new', [PenjualanController::class, 'formNewInvoice']);
            Route::post('new', [PenjualanController::class, 'createInvoice']);
            Route::get('list', [PenjualanController::class, 'showInvoiceList']);
            Route::get('delete-item', [PenjualanController::class, 'deleteInvoiceItem']);
        });

        Route::prefix('pembayaran')->group(function(){
            Route::get('/', [PenjualanController::class, 'showPembayaranHome']);
            Route::get('invoice', [PenjualanController::class, 'showPembayaranInvoice']);
            Route::post('add', [PenjualanController::class, 'savePembayaran']);
        });
        
        Route::prefix('transaksi')->group(function(){
            Route::get('/', [PenjualanController::class, 'showTransaksi']);
        });

        Route::prefix('lunas')->group(function(){
            Route::get('/', [PenjualanController::class, 'showTransaksiLunas']);
        });

        Route::prefix('retur')->group(function(){
            Route::get('/', [PenjualanController::class, 'showReturHome']);
        });
    });

    Route::prefix('laporan')->group(function() {
        Route::get('/', [LaporanController::class, 'showLaporanHomepage']);
        Route::get('pembelian', [LaporanController::class, 'showLaporanPembelian']);
        Route::get('penjualan', [LaporanController::class, 'showLaporanPenjualan']);
        Route::get('laba-rugi', [LaporanController::class, 'showLabaRugiHome']);
        Route::get('laba-rugi/tahun', [LaporanController::class, 'showLabaRugiTahunan']);
        Route::get('laba-rugi/bulan', [LaporanController::class, 'showLabaRugiBulanan']);
        // Route::post('laba-rugi', [LaporanController::class, 'saveLabaRugi']);
        Route::get('produk', [LaporanController::class, 'showLaporanProduk']);
        Route::get('jenis-barang', [LaporanController::class, 'showLaporanJenisBarang']);
    });

    Route::get('backup', [BackupController::class, 'backupDatabase']);
});