@extends('admin.template')

@section('meta')
<title>Laporan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}"> &nbsp; Laporan
</a>
@endsection
@section('content')
<div class="container-fluid p-3">
    <div class="row">
        <div class="col"><h3>LAPORAN</h3></div>
        <div class="col-1">
            Periode
        </div>
        <div class="col-3">
            @include('shared.select-month')
        </div>
        <div class="col-2">
            @include('shared.select-year')
        </div>
    </div>

    @include('shared.tabs-laporan')

    <div class="row mt-5">
        <div class="col-4 px-4">
            <div class="row laporan-head rounded">
                <div class="col-12">
                    <span id="monthly_profit" class="d-block fs-2">{{ number_format($monthly['profit'], 0) }}</span>
                    <span>Keuntungan</span>
                </div>
            </div>
        </div>
        <div class="col-4 px-4">
            <div class="row laporan-head rounded">
                <div class="col-12">
                    <span id="monthly_income" class="d-block fs-2">{{ number_format($monthly['income'], 0) }}</span>
                    <span>Total Pemasukan</span>
                </div>
            </div>
        </div>
        <div class="col-4 px-4">
            <div class="row laporan-head rounded">
                <div class="col-12">
                    <span id="monthly_expense" class="d-block fs-2">{{ number_format($monthly['expense'], 0) }}</span>
                    <span>Total Pengeluaran</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 p-3 laporan-head">
        <div class="col-12">
            <h2>Laporan Penjualan Per Periode</h2>
        </div>
        <div class="col-12 periode-selector">
            <button class="btn btn-light" onclick="refreshChart(3)">3 Bulan</button>
            <button class="btn btn-light" onclick="refreshChart(6)">6 Bulan</button>
            <button class="btn btn-light" onclick="refreshChart(12)">12 Bulan</button>
        </div>
        <div class="col-12">
            <div id="chart"></div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-6 pe-3">
            <div class="laporan-head p-3">
                <h2>Top #10 Best Seller</h2>
                <?php $x = 1; ?>
                @foreach ($best_seller as $row)
                <div class="row top-ten">
                    <div class="col-1">{{ $x }}</div>
                    <div class="col text-start">{{ $row->product_code }}</div>
                    <div class="col-3 text-start">{{ $row->total_qty }}</div>
                </div>
                <?php $x++; ?>
                @endforeach
            </div>
        </div>
        <div class="col-6 ps-3">
            <div class="laporan-head p-3">
                <h2>Top #10 Customer</h2>
                <?php $x = 1; ?>
                @foreach ($best_customer as $row)
                <div class="row top-ten">
                    <div class="col-1">{{ $x }}</div>
                    <div class="col text-start">{{ $row->customer_name }}</div>
                    <div class="col-3 text-start">{{ number_format($row->total_price, 0) }}</div>
                </div>
                <?php $x++; ?>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <button id="printButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
let chart = null;
let chartInitialized = false;

$(document).ready(function(){
    $('select[name=month]').val({{ date('m') }});
    $('select[name=year]').val({{ date('Y') }});
    refreshNumbers();
    refreshChart(3);
});

$('select').on('change', function(){
    refreshNumbers();
});
$('input').on('change', function(){
    refreshNumbers();
});

function refreshNumbers() {
    var month = $('select[name=month]').val();
    var year = $('input[name=year]').val();
    $.ajax({
        url: '{{ url('api/laporan-bulanan') }}',
        type: 'GET',
        dataType: 'json',
        data: {
            year: year,
            month: month
        },
    })
    .done(function(result) {
        $('#monthly_expense').text($.number(result.monthly.expense, 0));
        $('#monthly_income').text($.number(result.monthly.income, 0));
        $('#monthly_profit').text($.number(result.monthly.profit, 0));
    });
    
}

function refreshChart(range) {
    $.ajax({
        url: '{{ url('api/laporan-tx') }}',
        type: 'GET',
        dataType: 'json',
        data: {range: range},
    })
    .done(function(result) {
        const profitData = result.profit.map(item => item.amount);
        const expenseData = result.expenses.map(item => item.amount);
        const labels = result.profit.map(item => item.year_month);
        createApexChart(profitData, expenseData, labels);
    })
    .fail(function() {
    })
    .always(function() {
    });
}

function createApexChart(profit, expenses, labels) {
      const options = {
        series: [
          { name: 'Pengeluaran', data: expenses, },
          { name: 'Keuntungan', data: profit }
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

$('#printButton').on('click', function(){
    alert('Fitur belum tersedia');
});
</script>
@endsection