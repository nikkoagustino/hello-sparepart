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

        if (strtotime($request->date_end) < strtotime($request->date_start)) {
            return redirect('admin/laporan/pembelian')->withErrors('Periode akhir tidak boleh lebih rendah dari periode awal');
        }

        $data = [
            'suppliers' => SupplierModel::getAll(),
            'invoices' => PembelianModel::getInvoices($request),
        ];
        return view('admin/laporan/pembelian')->with($data);
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

    function showLaporanHomepage() {
        $current_date = date('Y-m-d');
        $monthly_expense = LaporanModel::getMonthlyExpense($current_date);
        $monthly_income = LaporanModel::getMonthlyIncome($current_date);
        $monthly_profit = $monthly_income->income - $monthly_expense->expense;

        $data = [
            'monthly' => [
                'expense' => (int) $monthly_expense->expense,
                'income' => (int) $monthly_income->income,
                'profit' => $monthly_profit,
            ],
           'best_seller' => (array) LaporanModel::getBestSeller()->toArray(),
        ];
        // dd($data);
        return view('admin.laporan.home')->with($data);
    }

    function getLaporanBulanan(Request $request) {
        $current_date = $request->year.'-'.$request->month.'-01';
        $monthly_expense = LaporanModel::getMonthlyExpense($current_date);
        $monthly_income = LaporanModel::getMonthlyIncome($current_date);
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
            array_push($income_data, $income_row);
            array_push($expense_data, $expense_row);

            $range--;
        }
        $data = [
            'incomes' => $income_data,
            'expenses' => $expense_data,
        ];

        return response()->json($data, 200);
    }

    function showLabaRugiForm() {
        $data = [
            'sales' => SalesModel::getAll(),
        ];
        return view('admin.laporan.laba-rugi')->with($data);
    }

    function getLabaRugi(Request $request) {
        $periode = $request->year.'-'.$request->month;
        $data = [
            'penjualan' => LaporanModel::getIncomeByMonth($request->year, $request->month),
            'komisi' => LaporanModel::getKomisiSalesByMonth($request->year, $request->month),
            'gaji' => LaporanModel::getGajiSalesByMonth($request->year, $request->month),
            'beban' => LaporanModel::getBebanOpsByMonth($request->year, $request->month) ?? [],
            'modal' => LaporanModel::getModalByMonth($request->year, $request->month),
        ];
        return response()->json($data, 200);
    }

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
}
