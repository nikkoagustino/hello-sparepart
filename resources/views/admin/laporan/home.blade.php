@extends('admin.template')

@section('meta')
<title>Laporan - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <i class="fa-solid fa-gear"></i> &nbsp; Laporan
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-12"><h3>LAPORAN BULAN INI</h3></div>
    <div class="col-4">
        <div class="row laporan-head">
            <div class="col-3">
                <i class="fa-solid fa-scale-balanced fs-1"></i>
            </div>
            <div class="col-9">
                <span class="d-block fs-2">{{ number_format($monthly['profit'], 0) }}</span>
                <span>Keuntungan</span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row laporan-head">
            <div class="col-3">
                <i class="fa-solid fa-scale-balanced fs-1"></i>
            </div>
            <div class="col-9">
                <span class="d-block fs-2">{{ number_format($monthly['income'], 0) }}</span>
                <span>Total Pemasukan</span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row laporan-head">
            <div class="col-3">
                <i class="fa-solid fa-scale-balanced fs-1"></i>
            </div>
            <div class="col-9">
                <span class="d-block fs-2">{{ number_format($monthly['expense'], 0) }}</span>
                <span>Total Pengeluaran</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 p-3 laporan-head">
    <div class="col-12">
        <h2>Laporan Penjualan Per Periode</h2>
    </div>
    <div class="col-12">
        <button class="btn btn-light" onclick="refreshChart(3)">3 Bulan</button>
        <button class="btn btn-light" onclick="refreshChart(6)">6 Bulan</button>
        <button class="btn btn-light" onclick="refreshChart(12)">12 Bulan</button>
    </div>
    <div class="col-12">
        <div id="chart"></div>
    </div>
</div>

<div class="row mt-5 laporan-head">
    <div class="col-12">
        <h2>Top #10 Best Seller</h2>
    </div>
    <div class="col-6">
        <table class="table table-striped">
            <tbody>
                @php
                list($left_array, $right_array) = array_chunk($best_seller, 5);
                @endphp
                @foreach($left_array as $row)
                <tr>
                    <td>{{ $row->product_code }}</td>
                    <td>{{ number_format($row->total_qty, 0) }} pcs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <table class="table table-striped">
            <tbody>
                @foreach($right_array as $row)
                <tr>
                    <td>{{ $row->product_code }}</td>
                    <td>{{ number_format($row->total_qty, 0) }} pcs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-5">
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ url('admin/laporan/penjualan') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-download"></i>
                    </span>
                    Penjualan
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/laporan/pembelian') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-upload"></i>
                    </span>
                    Pembelian
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/laporan/laba-rugi') }}" class="btn btn-selection btn-yellow">
                    <span class="display-1">
                        <i class="fa-solid fa-chart-pie"></i>
                    </span>
                    Laba Rugi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
let chart = null;
let chartInitialized = false;

$(document).ready(function(){
    refreshChart(3);
});

function refreshChart(range) {
    $.ajax({
        url: '{{ url('api/laporan-tx') }}',
        type: 'GET',
        dataType: 'json',
        data: {range: range},
    })
    .done(function(result) {
        const incomeData = result.incomes.map(item => item.amount);
        const expenseData = result.expenses.map(item => item.amount);
        const labels = result.incomes.map(item => item.year_month);
        createApexChart(incomeData, expenseData, labels);
    })
    .fail(function() {
    })
    .always(function() {
    });
}

function createApexChart(incomes, expenses, labels) {
      const options = {
        series: [
          { name: 'Pemasukan', data: incomes },
          { name: 'Pengeluaran', data: expenses }
        ],
        chart: {
          type: 'bar',
          height: 400
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '45%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
        },
        yaxis: {
          title: {
            text: 'Nominal'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
          }
        }
      };
// Destroy existing chart if it has been initialized
      if (chartInitialized) {
        chart.destroy();
      }
      chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
      chartInitialized = true;
    }

</script>
@endsection