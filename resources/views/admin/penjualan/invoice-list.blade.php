@extends('admin.template')

@section('meta')
<title>Penjualan - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-invoice-dollar"></i> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
        <a href="{{ url('admin/penjualan/invoice/detail') }}" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-search"></i>
            Cari
        </a>
        <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-arrow-pointer"></i>
            Detail
        </button>
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
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal Invoice</th>
                    <th>Kode Customer</th>
                    <th>Nama Customer</th>
                    <th>Kode Sales</th>
                    <th>Nama Sales</th>
                    <th>Jatuh Tempo</th>
                    <th>Qty Barang</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $row)
                <tr data-id="{{ $row->invoice_no }}">
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->customer_code }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->sales_code }}</td>
                    <td>{{ $row->sales_name }}</td>
                    <td>{{ $row->expiry_date }}</td>
                    <td>{{ number_format($row->total_qty, 0) }}</td>
                    <td>{{ number_format($row->total_price, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href="{{ url('admin/penjualan/invoice/new') }}";
    });
    $('#detailButton').on('click', function(){
        if (!selected_row) {
            alert('Pilih invoice terlebih dahulu');
            return;
        }
        window.location.href="{{ url('admin/penjualan/invoice/detail') }}?invoice_no="+selected_row;
    });
    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/invoice-sell-list') }}', 'printWindow');
    });
</script>
@endsection