@extends('admin.template')

@section('meta')
<title>{{ $product->product_name }} - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/product.svg') }}"> &nbsp; Produk
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-4">
                Kode Barang
            </div>
            <div class="col">
                <input type="text" readonly="readonly" value="{{ $product->product_code }}" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4">
                Nama Barang
            </div>
            <div class="col">
                <input type="text" readonly="readonly" value="{{ $product->product_name }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
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
                    <th>No. Invoice</th>
                    <th>Tgl. Invoice</th>
                    <th>Status</th>
                    <th>Kode Supp / Cust</th>
                    <th>Nama Supp / Cust</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $row)
                <tr data-status="{{ $row->status }}" data-id="{{ $row->invoice_no }}">
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->cust_supp_code }}</td>
                    <td>{{ $row->cust_supp_name }}</td>
                    <td>{{ number_format($row->qty, 0) }}</td>
                    <td>{{ number_format($row->subtotal_price, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    var type_invoice = '';
    $('.selectable').on('click', 'tbody tr', function() {
        type_invoice = $(this).data('status');
    });
    $('#detailButton').on('click', function(){
        if (selected_row) {
            if ((type_invoice == 'JUAL') || (type_invoice == 'RETUR-JUAL')) {
                window.location.href='{{ url('admin/penjualan/invoice/detail?invoice_no=') }}'+selected_row;
            } else {
                window.location.href='{{ url('admin/pembelian/invoice/detail?invoice_no=') }}'+selected_row;
            }
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/product/tx?product_code='.$product_code) }}', 'printWindow');
    })
</script>
@endsection