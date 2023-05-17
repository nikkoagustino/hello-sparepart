@extends('admin.template')

@section('meta')
<title>List Piutang - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/transaksi') }}" class="btn btn-danger">
    <i class="fa-solid fa-cash-register"></i> &nbsp; Transaksi
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">
                Periode
            </div>
            <div class="col-3">
                <input type="date" value="{{ $_GET['date_start'] ?? '' }}" name="date_start" class="form-control">
            </div>
            <div class="col-1">
                s/d
            </div>
            <div class="col-3">
                <input type="date" value="{{ $_GET['date_end'] ?? '' }}" name="date_end" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Customer
            </div>
            <div class="col-3">
                <select name="customer_code" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($customers as $row)
                    <option data-code="{{ $row->customer_code }}" data-name="{{ $row->customer_name }}" value="{{ $row->customer_code }}">{{ $row->customer_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="customer_name" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($customers as $row)
                    <option data-code="{{ $row->customer_code }}" data-name="{{ $row->customer_name }}" value="{{ $row->customer_name }}">{{ $row->customer_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Jenis Barang
            </div>
            <div class="col-3">
                <select name="product_code" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($products as $row)
                    <option data-code="{{ $row->product_code }}" data-name="{{ $row->product_name }}" value="{{ $row->product_code }}">{{ $row->product_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="product_name" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($products as $row)
                    <option data-code="{{ $row->product_code }}" data-name="{{ $row->product_name }}" value="{{ $row->product_name }}">{{ $row->product_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col text-end">
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
        <table class="table table-striped table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Kode Cust</th>
                    <th>Nama Cust</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td class="total_invoice_price">
                    0
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('input').attr('autocomplete', 'off');
        refreshData();
    });

    $('input').on('change', function() {
        refreshData();
    });

    $('select[name=product_code]').on('change', function(){
        var product_name = $(this).find(':selected').data('name');
        $('select[name=product_name]').val(product_name);
        refreshData();
    });
    $('select[name=product_name]').on('change', function(){
        var product_code = $(this).find(':selected').data('code');
        $('select[name=product_code]').val(product_code);
        refreshData();
    });
    $('select[name=customer_code]').on('change', function(){
        var customer_name = $(this).find(':selected').data('name');
        $('select[name=customer_name]').val(customer_name);
        refreshData();
    });
    $('select[name=customer_name]').on('change', function(){
        var customer_code = $(this).find(':selected').data('name');
        $('select[name=customer_code]').val(customer_code);
        refreshData();
    });

    function refreshData() {
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        var product_code = $('select[name=product_code]').val();
        $.ajax({
            url: '{{ url('api/penjualan/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                date_start: date_start,
                date_end: date_end,
                customer_code: customer_code,
                product_code: product_code,
            }
        })
        .done(function(result) {
            $('#itemsTable tbody').html('');
            var total_invoice_price = 0;
            $.each(result, function(index, val) {
                $('#itemsTable tbody').append('<tr data-id="'+val.invoice_no+'">' +
                    '<td>'+val.invoice_no+'</td>' +
                    '<td>'+val.invoice_date+'</td>' +
                    '<td>'+val.customer_code+'</td>' +
                    '<td>'+val.customer_name+'</td>' +
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '</tr>');
                    total_invoice_price = total_invoice_price + parseInt(val.total_price);
            });
            $('.total_invoice_price').text($.number(total_invoice_price, 0));
        })
        .fail(function() {
        })
        .always(function(result) {
        });
    }
</script>
@endsection