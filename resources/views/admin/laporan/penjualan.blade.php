@extends('admin/template')
@section('meta')
<title>Laporan Penjualan - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Laporan
</a>
<a href="{{ url('admin/laporan/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col-3">
                    Periode
                </div>
                <div class="col-4">
                    <input type="date" value="{{ $_GET['date_start'] ?? '' }}" name="date_start" class="form-control">
                </div>
                <div class="col-1">
                    s/d
                </div>
                <div class="col-4">
                    <input type="date" value="{{ $_GET['date_end'] ?? '' }}" name="date_end" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    Kode Customer
                </div>
                <div class="col-9">
                    <select name="customer_code" class="form-select form-control">
                        <option value="">Semua Customer...</option>
                        @foreach ($customers as $row)
                        <option {{ (isset($_GET['customer_code']) && ($row->customer_code == $_GET['customer_code'])) ? 'selected="selected"' : ''; }} value="{{ $row->customer_code }}">{{ $row->customer_code }} - {{ $row->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4 text-end">
            <button id="printButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
</div>  
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Tanggal Invoice</th>
                    <th>Jatuh Tempo</th>
                    <th>Nama Customer</th>
                    <th>Status</th>
                    <th>Qty Barang</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($invoices as $row)
                <tr data-id="{{ $row->invoice_no }}">
                    <td>{{ $no }}</td>
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->expiry_date }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->payment_type }}</td>
                    <td>{{ number_format($row->total_qty, 0) }}</td>
                    <td>{{ number_format($row->total_price, 0) }}</td>
                </tr>
                @php $no++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    $('input').on('change', function(){
        refreshData();
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData() {
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        var query = new URLSearchParams({
            'date_start': date_start,
            'date_end': date_end,
            'customer_code': customer_code,
        });
        window.location.href='{{ url()->current() }}?'+query.toString();
    }
</script>
@endsection