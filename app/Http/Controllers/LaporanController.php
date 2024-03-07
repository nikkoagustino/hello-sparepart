<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianModel;
use App\Models\PenjualanModel;
use App\Models\LaporanModel;
use App\Models\CustomerModel;
use App\Models\SupplierModel;
use App\Models\SalesModel;
use App\Models\ProductModel;
use App\Models\ProductTypeModel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    function showLaporanPembelian(Request $request) {
        $request->validate([
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'supplier_code' => 'nullable|string',
        ]);

        if ($request->date_end && $request->date_start) {
            if (strtotime($request->date_end) < strtotime($request->date_start)) {
                return redirect('admin/laporan/pembelian')->withErrors('Periode akhir tidak boleh lebih rendah dari periode awal');
            }
        }

        $data = [
            'suppliers' => SupplierModel::getAll(),
            'invoices' => PembelianModel::getInvoices($request),
        ];
        return view('admin/laporan/pembelian')->with($data);
    }

    function printLaporanPembelian(Request $request) {
        $request->validate([
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'supplier_code' => 'nullable|string',
        ]);

        if ($request->date_end && $request->date_start) {
            if (strtotime($request->date_end) < strtotime($request->date_start)) {
                return redirect('admin/laporan/pembelian')->withErrors('Periode akhir tidak boleh lebih rendah dari periode awal');
            }
        }

        $data = [
            'suppliers' => SupplierModel::getAll(),
            'invoices' => PembelianModel::getInvoices($request),
        ];
        return view('admin/print/laporan-pembelian')->with($data);
    }

    function showLaporanPenjualan(Request $request) {
        $request->validate([
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'customer_code' => 'nullable|string',
        ]);

        if (strtotime($request->date_end) < strtotime($request->date_start)) {
            return redirect('admin/laporan/penjualan')->withErrors('Periode akhir tidak boleh lebih rendah dari periode awal');
        }


        $data = [
            'customers' => CustomerModel::getAll(),
            'invoices' => PenjualanModel::getInvoices($request),
        ];
        return view('admin/laporan/penjualan')->with($data);
    }
    function printLaporanPenjualan(Request $request) {
        $request->validate([
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'customer_code' => 'nullable|string',
        ]);

        if (strtotime($request->date_end) < strtotime($request->date_start)) {
            return redirect('admin/laporan/penjualan')->withErrors('Periode akhir tidak boleh lebih rendah dari periode awal');
        }


        $data = [
            'customers' => CustomerModel::getAll(),
            'invoices' => PenjualanModel::getInvoices($request),
        ];
        return view('admin/print/laporan-penjualan')->with($data);
    }

    function showLaporanHomepage() {
        $data = [
           'best_seller' => (array) LaporanModel::getBestSeller()->toArray(),
           'best_customer' => (array) LaporanModel::getBestCustomer()->toArray(),
        ];
        // dd($data);
        return view('admin.laporan.home')->with($data);
    }

    function getLaporanBulanan(Request $request) {
        $monthly_expense = LaporanModel::getMonthlyExpense($request);
        $monthly_income = LaporanModel::getMonthlyIncome($request);
        $monthly_profit = $monthly_income->income - $monthly_expense->expense;

        $data = [
            'monthly' => [
                'expense' => (int) $monthly_expense->expense,
                'income' => (int) $monthly_income->income,
                'profit' => (int) $monthly_profit,
            ],
        ];
        return response()->json($data, 200);
    }

    function getLaporanTahunan(Request $request) {
        $data = [
            'reports' => LaporanModel::getYearlyLabaRugi($request->year),
        ];
        return response()->json($data, 200);
    }

    function printLabaRugiTahunan(Request $request) {
        $data = [
            'reports' => LaporanModel::getYearlyLabaRugi($request->year),
            'year' => $request->year,
        ];
        return view('admin/print/laba-rugi-tahunan')->with($data);
    }

    function getLaporanTransaksi(Request $request) {
        $data = [
            'expenses' => LaporanModel::getExpenseBulanan($request->range),
            'incomes' => LaporanModel::getIncomeBulanan($request->range)
        ];
        return response()->json($data, 200);
    }

    function getLaporanTransaksiV2(Request $request) {
        $range = $request->range;
        $income_data = [];
        $expense_data = [];
        $profit_data = [];
        while ($range > 0) {
            $start_date = Carbon::now()->subMonths($range - 1)->startOfMonth();
            $year = date('Y', strtotime($start_date));
            $month = date('m', strtotime($start_date));
            $income_row = [
                'year_month' => $year.'-'.$month,
                'amount' => (int) LaporanModel::getIncomeByMonth($year, $month)->amount ?? 0,
            ];
            $expense_row = [
                'year_month' => $year.'-'.$month,
                'amount' => (int) LaporanModel::getExpenseByMonth($year, $month)->amount ?? 0,
            ];
            $profit_row = [
                'year_month' => $year.'-'.$month,
                'amount' => $income_row['amount'] - $expense_row['amount'],
            ];
            array_push($income_data, $income_row);
            array_push($expense_data, $expense_row);
            array_push($profit_data, $profit_row);

            $range--;
        }
        $data = [
            'incomes' => $income_data,
            'expenses' => $expense_data,
            'profit' => $profit_data,
        ];

        return response()->json($data, 200);
    }

    function showLabaRugiHome() {
        return view('admin.laporan.laba-rugi');
    }

    function showLabaRugiTahunan() {
        return view('admin.laporan.laba-rugi-tahunan');
    }

    // function showLabaRugiBulanan() {
    //     $data = [
    //         'sales' => SalesModel::getAll(),
    //     ];
    //     return view('admin.laporan.laba-rugi-bulanan')->with($data);
    // }

    // function getLabaRugi(Request $request) {
    //     $data = [
    //         'penjualan' => LaporanModel::getIncomeByMonth($request->year, $request->month),
    //         'komisi' => LaporanModel::getKomisiSalesByMonth($request->year, $request->month),
    //         'gaji' => LaporanModel::getGajiSalesByMonth($request->year, $request->month),
    //         'beban' => LaporanModel::getBebanOpsByMonth($request->year, $request->month) ?? [],
    //         'modal' => LaporanModel::getModalByMonth($request->year, $request->month),
    //     ];
    //     return response()->json($data, 200);
    // }

    // function printLabaRugiBulanan(Request $request) {
    //     $data = [
    //         'penjualan' => LaporanModel::getIncomeByMonth($request->year, $request->month),
    //         'komisi' => LaporanModel::getKomisiSalesByMonth($request->year, $request->month),
    //         'gaji' => LaporanModel::getGajiSalesByMonth($request->year, $request->month),
    //         'beban' => LaporanModel::getBebanOpsByMonth($request->year, $request->month) ?? [],
    //         'modal' => LaporanModel::getModalByMonth($request->year, $request->month),
    //     ];
    //     return view('admin/print/laba-rugi-bulanan')->with($data);
    // }

    function saveLabaRugi(Request $request) {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|string|size:2',
            'komisi.*' => 'nullable|integer',
            'gaji.*' => 'nullable|integer',
            'inventaris' => 'nullable|integer',
            'reimburse' => 'nullable|integer',
            'pulsa' => 'nullable|integer',
        ]);

        // save beban ops
        LaporanModel::saveBebanOps($request);

        // save komisi
        $komisi = $request->input('komisi');
        foreach ($komisi as $sales_code => $value) {
            $data = [
                'sales_code' => $sales_code,
                'amount' => $value,
                'periode' => $request->year.'-'.$request->month,
            ];
            $data = (object) $data;
            LaporanModel::saveKomisi($data);
        }

        // save gaji
        $gaji = $request->input('gaji');
        foreach ($gaji as $sales_code => $value) {
            $data = [
                'sales_code' => $sales_code,
                'amount' => $value,
                'periode' => $request->year.'-'.$request->month,
            ];
            $data = (object) $data;
            LaporanModel::saveGaji($data);
        }

        return redirect('admin/laporan/laba-rugi')->withSuccess('Berhasil simpan data');
    }

    function showLaporanProduk() {
        $data = [
            'products' => ProductModel::getAll(),
        ];
        return view('admin/laporan/produk')->with($data);
    }

    function showLaporanJenisBarang() {
        $data = [
            'product_types' => ProductTypeModel::getAll(),
        ];
        return view('admin/laporan/product-type')->with($data);
    }

    function showLaporanCustomer() {
        $data = [
            'customers' => CustomerModel::getAll(),
        ];
        return view('admin/laporan/customer')->with($data);
    }

    function getLaporanProduct(Request $request) {
        $response = [
            'success' => true,
            'data' => LaporanModel::getLaporanProduct($request),
        ];
        return response()->json($response, 200);
    }
    function getLaporanProductType(Request $request) {
        $response = [
            'success' => true,
            'data' => LaporanModel::getLaporanProductType($request),
        ];
        return response()->json($response, 200);
    }

    function printProductTx(Request $request) {
        $data = [
            'product_code' => $request->product_code,
            'product' => ProductModel::getById($request->product_code),
            'transactions' => ProductModel::getProductTransactions($request->product_code),
            // 'laba_rugi' => ProductModel::getProductLabaRugi($request->product_code),
        ];
        return view('admin/print/product-transactions')->with($data);
    }

    function showDashboardLabaRugi(Request $request)
    {
        return view('admin/dashboard/laba-rugi');
    }

    function getDashboardLabaRugi(Request $request)
    {
        $output = [
            'success' => true,
            'data' => [
                'penjualan_kotor' => (int) LaporanModel::getPenjualanKotor($request) ?? 0,
                'modal_bersih' => (int) LaporanModel::getModalBersih($request) ?? 0,
                'komisi_sales' => (int) LaporanModel::getKomisiSales($request) ?? 0,
                'beban_ops' => (int) LaporanModel::getBebanOps($request) ?? 0,
                'gaji' => (int) LaporanModel::getGajiSales($request) ?? 0,
            ],
            'breakdown' => [
                'komisi' => LaporanModel::getKomisiSalesDetail($request),
                'gaji' => LaporanModel::getGajiSalesDetail($request),
                'beban_ops' => [
                    'inventaris' => LaporanModel::getInventarisSum($request),
                    'reimburse' => LaporanModel::getReimburseSum($request),
                    'pulsa' => LaporanModel::getPulsaSum($request),
                    'other' => LaporanModel::getBebanOpsOtherSum($request),
                ],
            ]
        ];
        return response()->json($output, 200);
    }

    function printLaporanLabaRugi(Request $request)
    {
        $data = [
            'success' => true,
            'data' => [
                'penjualan_kotor' => (int) LaporanModel::getPenjualanKotor($request) ?? 0,
                'modal_bersih' => (int) LaporanModel::getModalBersih($request) ?? 0,
                'komisi_sales' => (int) LaporanModel::getKomisiSales($request) ?? 0,
                'beban_ops' => (int) LaporanModel::getBebanOps($request) ?? 0,
                'gaji' => (int) LaporanModel::getGajiSales($request) ?? 0,
            ],
            'breakdown' => [
                'komisi' => LaporanModel::getKomisiSalesDetail($request),
                'gaji' => LaporanModel::getGajiSalesDetail($request),
                'beban_ops' => [
                    'inventaris' => LaporanModel::getInventarisSum($request),
                    'reimburse' => LaporanModel::getReimburseSum($request),
                    'pulsa' => LaporanModel::getPulsaSum($request),
                    'other' => LaporanModel::getBebanOpsOtherSum($request),
                ],
            ]
        ];
        $pdf = \PDF::loadView('admin/print/laporan-laba-rugi', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function printRangkumanLabaRugi(Request $request)
    {
        $data = [
            'penjualan_kotor' => (int) LaporanModel::getPenjualanKotor($request) ?? 0,
            'modal_bersih' => (int) LaporanModel::getModalBersih($request) ?? 0,
            'komisi_sales' => (int) LaporanModel::getKomisiSales($request) ?? 0,
            'beban_ops' => (int) LaporanModel::getBebanOps($request) ?? 0,
        ];

        $pdf = \PDF::loadView('admin/print/rangkuman-laba-rugi', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function getRekapProduk(Request $request)
    {
        if ($request->kategori === 'penjualan') {
            $data = LaporanModel::getRekapPenjualanProduk($request);
        } else if ($request->kategori === 'pembelian') {
            $data = LaporanModel::getRekapPembelianProduk($request);
        } else {
            $data = null;
        }
        $response = [
            'success' => true,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    function printLaporanProduk(Request $request)
    {
        if ($request->kategori === 'penjualan') {
            $data = LaporanModel::getRekapPenjualanProduk($request);
        } else if ($request->kategori === 'pembelian') {
            $data = LaporanModel::getRekapPembelianProduk($request);
        } else {
            $data = null;
        }
        $response = [
            'success' => true,
            'data' => $data
        ];
        $pdf = \PDF::loadView('admin/print/laporan-produk', $response);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function getRekapJenisBarang(Request $request)
    {
        if ($request->kategori === 'penjualan') {
            $data = LaporanModel::getRekapPenjualanJenisBarang($request);
        } else if ($request->kategori === 'pembelian') {
            $data = LaporanModel::getRekapPembelianJenisBarang($request);
        } else {
            $data = null;
        }
        $response = [
            'success' => true,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    function printLaporanJenisBarang(Request $request)
    {
        if ($request->kategori === 'penjualan') {
            $data = LaporanModel::getRekapPenjualanJenisBarang($request);
        } else if ($request->kategori === 'pembelian') {
            $data = LaporanModel::getRekapPembelianJenisBarang($request);
        } else {
            $data = null;
        }
        $response = [
            'success' => true,
            'data' => $data
        ];
        $pdf = \PDF::loadView('admin/print/laporan-jenis-barang', $response);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function getRekapCustomer(Request $request)
    {
        $response = [
            'success' => true,
            'data' => LaporanModel::getRekapCustomer($request),
        ];
        return response()->json($response, 200);
    }

    function printLaporanCustomer(Request $request)
    {
        $response = [
            'success' => true,
            'customer' => CustomerModel::getById($request->customer_code),
            'data' => LaporanModel::getRekapCustomer($request),
        ];
        $pdf = \PDF::loadView('admin/print/laporan-customer', $response);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    function printLaporanGeneral(Request $request)
    {
        // monthly data
        $monthly_expense = LaporanModel::getMonthlyExpense($request);
        $monthly_income = LaporanModel::getMonthlyIncome($request);
        $monthly_profit = $monthly_income->income - $monthly_expense->expense;

        $monthly_data = [
            'monthly' => [
                'expense' => (int) $monthly_expense->expense,
                'income' => (int) $monthly_income->income,
                'profit' => (int) $monthly_profit,
            ],
        ];

        // chart data
        $range = $request->chart_range;
        $income_data = [];
        $expense_data = [];
        $profit_data = [];
        while ($range > 0) {
            $start_date = Carbon::now()->subMonths($range - 1)->startOfMonth();
            $year = date('Y', strtotime($start_date));
            $month = date('m', strtotime($start_date));
            $income_row = [
                'month_name' => date('F', strtotime($start_date)),
                'amount' => (int) LaporanModel::getIncomeByMonth($year, $month)->amount ?? 0,
            ];
            $expense_row = [
                'month_name' => date('F', strtotime($start_date)),
                'amount' => (int) LaporanModel::getExpenseByMonth($year, $month)->amount ?? 0,
            ];
            $profit_row = [
                'month_name' => date('F', strtotime($start_date)),
                'amount' => $income_row['amount'] - $expense_row['amount'],
            ];
            array_push($income_data, $income_row);
            array_push($expense_data, $expense_row);
            array_push($profit_data, $profit_row);

            $range--;
        }
        $chart_data = [
            'incomes' => $income_data,
            'expenses' => $expense_data,
            'profit' => $profit_data,
        ];

        $response = [
            'monthly' => $monthly_data,
            'chart' => $chart_data,
           'best_seller' => (array) LaporanModel::getBestSeller()->toArray(),
           'best_customer' => (array) LaporanModel::getBestCustomer()->toArray(),
        ];
        $pdf = \PDF::loadView('admin/print/laporan-general', $response);
        return $pdf->setPaper('a4', 'portrait')->stream();
    }
}
