@extends('admin.template')

@section('meta')
<title>Pembayaran Invoice - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/pembayaran') }}" class="btn btn-danger">
    <i class="fa-solid fa-circle-dollar-to-slot"></i> &nbsp; Pembayaran
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-9">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-9">
                <input type="date" readonly="readonly" name="invoice_date" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Customer
            </div>
            <div class="col-9">
                <input name="customer_code" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Sales
            </div>
            <div class="col-9">
                <input name="sales_code" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Status
            </div>
            <div class="col-9">
                <input name="payment_type" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="payButton" class="btn btn-danger btn-icon-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
            <i class="fa-solid fa-circle-dollar-to-slot"></i>
            Bayar
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
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga /pcs</th>
                    <th>Disc (%)</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">Total</td>
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
    var invoice_no;
    var invoice_data = null;
    var total_outstanding = 0;
    $('input[name=invoice_no]').on('change paste keyup', function(){
        invoice_no = $(this).val();
        $.ajax({
            url: '{{ url('api/invoice/penjualan') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            invoice_data = result.data;
            $('input[name=invoice_date]').val(invoice_data.invoice_date);
            $('input[name=days_expire]').val(invoice_data.days_expire);
            $('input[name=description]').val(invoice_data.description);
            $('input[name=customer_code]').val(invoice_data.customer_code +' - '+ invoice_data.customer_name);
            $('input[name=sales_code]').val(invoice_data.sales_code +' - '+ invoice_data.sales_name);
            $('input[name=payment_type]').val(invoice_data.payment_type);
            getInvoiceItems(invoice_no);
        })
        .fail(function() {
            invoice_data = null;
            $('input[name=invoice_date]').val('');
            $('input[name=days_expire]').val('');
            $('input[name=description]').val('');
            $('input[name=customer_code]').val('');
            $('input[name=sales_code]').val('');
            $('input[name=payment_type]').val('');
            $('.total_invoice_price').val(0);
        })
        .always(function(result) {
        });
    });

    function getInvoiceItems(invoice_no) {
        $.ajax({
            url: '{{ url('api/invoice/penjualan/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            var table_row = '';
            var total_invoice_price = 0;
            $.each(result.data, function(index, row) {
                table_row += '<tr data-id="'+row.product_code+'">' +
                    '<td>'+row.product_code+'</td>' +
                    '<td>'+row.type_code+'</td>' +
                    '<td>'+row.product_name+'</td>' +
                    '<td>'+$.number(row.qty, 0)+'</td>' +
                    '<td>'+$.number(row.normal_price, 0)+'</td>' +
                    '<td>'+$.number(row.discount_rate, 2)+'</td>' +
                    '<td>'+$.number(row.subtotal_price, 0)+'</td>' +
                    '</tr>';
                    total_invoice_price = total_invoice_price + parseInt(row.subtotal_price);
            });
            $('#itemsTable tbody').html(table_row);
            $('.total_invoice_price').text($.number(total_invoice_price, 0));
        })
        .fail(function() {
        })
        .always(function(result) {
        });
    }

    $('#payButton').on('click', function(){
        if (!invoice_data) {
            alert('Cari Invoice Terlebih Dahulu');
        } else {
            window.location.href='{{ url('admin/penjualan/pembayaran/invoice') }}/'+invoice_no;
        }
    });
</script>
@endsection