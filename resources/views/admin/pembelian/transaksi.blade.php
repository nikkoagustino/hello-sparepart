@extends('admin.template')

@section('meta')
<title>List Transaksi - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/transaksi') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/transaksi.svg') }}"> &nbsp; Transaksi
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
                Kode Supplier
            </div>
            <div class="col-3">
                <select name="supplier_code" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($suppliers as $row)
                    <option data-code="{{ $row->supplier_code }}" data-name="{{ $row->supplier_name }}" value="{{ $row->supplier_code }}">{{ $row->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="supplier_name" class="form-select form-control">
                    <option data-code="" data-name="" value=""></option>
                    @foreach ($suppliers as $row)
                    <option data-code="{{ $row->supplier_code }}" data-name="{{ $row->supplier_name }}" value="{{ $row->supplier_name }}">{{ $row->supplier_name }}</option>
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
        <table class="table table-striped print table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Total Invoice</th>
                    <th>Total Pembayaran</th>
                    <th>Sisa Hutang</th>
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
                    <td class="total_pembayaran">
                    0
                    </td>
                    <td class="total_hutang">
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
    $('select[name=supplier_code]').on('change', function(){
        var supplier_name = $(this).find(':selected').data('name');
        $('select[name=supplier_name]').val(supplier_name);
        refreshData();
    });
    $('select[name=supplier_name]').on('change', function(){
        var supplier_code = $(this).find(':selected').data('name');
        $('select[name=supplier_code]').val(supplier_code);
        refreshData();
    });

    function refreshData() {
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var supplier_code = $('select[name=supplier_code]').val();
        var product_code = $('select[name=product_code]').val();
        $.ajax({
            url: '{{ url('api/pembelian/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                date_start: date_start,
                date_end: date_end,
                supplier_code: supplier_code,
                product_code: product_code,
            }
        })
        .done(function(result) {
            $('#itemsTable tbody').html('');
            var total_invoice_price = 0;
            var total_pembayaran = 0;
            var total_hutang = 0;
            $.each(result, function(index, val) {
                $('#itemsTable tbody').append('<tr data-id="'+val.invoice_no+'">' +
                    '<td>'+val.invoice_no+'</td>' +
                    '<td>'+val.invoice_date+'</td>' +
                    '<td>'+val.supplier_code+'</td>' +
                    '<td>'+val.supplier_name+'</td>' +
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '<td>'+$.number(val.total_paid_amount, 0)+'</td>' +
                    '<td>'+$.number(val.hutang, 0)+'</td>' +
                    '</tr>');
                    total_invoice_price = total_invoice_price + parseInt(val.total_price);
                    total_pembayaran = total_pembayaran + parseInt(val.total_paid_amount);
                    total_hutang = total_hutang + parseInt(val.hutang);
            });
            $('.total_invoice_price').text($.number(total_invoice_price, 0));
            $('.total_pembayaran').text($.number(total_pembayaran, 0));
            $('.total_hutang').text($.number(total_hutang, 0));
        })
        .fail(function() {
        })
        .always(function(result) {
            console.log(result);
        });
    }
</script>
@endsection