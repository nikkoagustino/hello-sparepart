@extends('admin.template')

@section('meta')
<title>Invoice Retur - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/transaksi') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/transaksi.svg') }}"> &nbsp; Transaksi
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-6">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-3">
                <input type="date" readonly="readonly" name="invoice_date" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Customer
            </div>
            <div class="col-3">
                <input name="customer_code" readonly="readonly" class="form-control">
            </div>
            <div class="col-6">
                <input name="customer_name" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Sales
            </div>
            <div class="col-3">
                <input name="sales_code" readonly="readonly" class="form-control">
            </div>
            <div class="col-6">
                <input name="sales_name" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Alamat
            </div>
            <div class="col-9">
                <textarea name="address" rows="3" readonly="readonly" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Jatuh Tempo
            </div>
            <div class="col-2">
                <input name="days_expire" readonly="readonly" class="form-control">
            </div>
            <div class="col-1">
                Hari
            </div>
            <div class="col-1">Ket</div>
            <div class="col">
                <input type="text" class="form-control" name="description" readonly="readonly">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Status
            </div>
            <div class="col-3">
                <input name="payment_type" readonly="readonly" class="form-control">
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
    <div class="col-12">
        <table class="table table-striped print table-condensed" id="itemsTable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga /pcs</th>
                    <th>Disc (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col"></div>
    <div class="col-1">Total</div>
    <div class="col-2 text-end">
        <input type="text" data-type="number" class="form-control bg-khaki" readonly="readonly" name="total_invoice_price">
    </div>
</div>
{{-- <div class="row mt-5" id="returWrapper">
    <div class="breadcrumb">
        <div class="col-12">
            <a href="javascript:void(0)" class="btn btn-danger">
                <img src="{{ url('assets/img/svg/retur.svg') }}"> &nbsp; Barang Retur
            </a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-striped print table-condensed selectable" id="returItemsTable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga /pcs</th>
                    <th>Disc (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col"></div>
    <div class="col-1">Total</div>
    <div class="col-2 text-end">
        <input type="text" data-type="number" class="form-control bg-khaki" readonly="readonly" name="total_returned_price">
    </div>
</div>
 --}}

@endsection
@section('script')
<script>

    $('input[name=invoice_no]').on('change paste keyup', function(){
        var invoice_no = $(this).val();
        $.ajax({
            url: '{{ url('api/invoice/penjualan') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            $('input[name=invoice_date]').val(result.data.invoice_date);
            $('input[name=days_expire]').val(result.data.days_expire);
            $('input[name=description]').val(result.data.description);
            $('input[name=customer_code]').val(result.data.customer_code);
            $('input[name=customer_name]').val(result.data.customer_name);
            $('input[name=sales_code]').val(result.data.sales_code);
            $('input[name=sales_name]').val(result.data.sales_name);
            $('input[name=payment_type]').val(result.data.payment_type);
            $('textarea[name=address]').text(result.data.customer_address);
            getInvoiceItems(invoice_no);
            getReturnedItems(invoice_no);
        })
        .fail(function() {
            $('input[name=invoice_date]').val('');
            $('input[name=days_expire]').val('');
            $('input[name=description]').val('');
            $('input[name=customer_code]').val('');
            $('input[name=sales_code]').val('');
            $('input[name=payment_type]').val('');
            $('textarea[name=address]').text('');
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
            var retur_dropdown = '';
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

                retur_dropdown += '<option data-max="'+row.qty+'" value="'+row.product_code+'">'+row.product_code+' - '+row.product_name+'</option>';
            });
            $('#itemsTable tbody').html(table_row);
            $('input[name=total_invoice_price]').val(total_invoice_price).change();
            $('select[name=returItemCode]').html(retur_dropdown);
        });
    }

    function getReturnedItems(invoice_no) {
        $.ajax({
            url: '{{ url('api/penjualan/retur/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            var table_row = '';
            var total_returned_price = 0;
            $.each(result.data, function(index, row) {
                table_row += '<tr data-id="'+row.id+'">' +
                    '<td>'+row.product_code+'</td>' +
                    '<td>'+row.type_code+'</td>' +
                    '<td>'+row.product_name+'</td>' +
                    '<td>'+$.number(row.qty, 0)+'</td>' +
                    '<td>'+$.number(row.normal_price, 0)+'</td>' +
                    '<td>'+$.number(row.discount_rate, 2)+'</td>' +
                    '<td>'+$.number(row.subtotal_price, 0)+'</td>' +
                    '</tr>';
                    total_returned_price = total_returned_price + parseInt(row.subtotal_price);
            });
            $('#returItemsTable tbody').html(table_row);
            $('input[name=total_returned_price]').val(total_returned_price).change();
        })
        .fail(function(xhr, result){
            $('#returWrapper').hide();
        });
    }

    @if ($_GET)
    @if ($_GET['invoice_no'])
        $('input[name=invoice_no]').val('{{ $_GET['invoice_no'] }}').trigger('change').attr('readonly', 'readonly');
    @endif
    @endif

    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        window.open('{{ url('admin/print/invoice-sell') }}?invoice_no='+invoice_no, 'printWindow');
    });
</script>
@endsection