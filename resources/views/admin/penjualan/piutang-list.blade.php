@extends('admin.template')

@section('meta')
<title>List Piutang - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/pembayaran') }}" class="btn btn-danger">
    <i class="fa-solid fa-arrow-up-from-bracket"></i> &nbsp; Piutang
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-7">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-9">
                <input name="invoice_no" placeholder="INVxxx" type="text" autocomplete="off" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
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
        <div class="row mt-1">
            <div class="col-3">
                Kode Customer
            </div>
            <div class="col-9">
                <select name="customer_code" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled">Pilih Customer...</option>
                    @foreach ($customers as $row)
                    <option value="{{ $row->customer_code }}">{{ $row->customer_code }} - {{ $row->customer_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Status
            </div>
            <div class="col-9">
                <select name="payment_type" required="required" class="form-select form-control">
                    <option value="">Semua Status...</option>
                    <option {{ (isset($_GET['status']) && ($_GET['status'] == 'TUNAI')) ? 'selected="selected"' : ''; }} value="TUNAI">TUNAI</option>
                    <option {{ (isset($_GET['status']) && ($_GET['status'] == 'KREDIT')) ? 'selected="selected"' : ''; }} value="KREDIT">KREDIT</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-file"></i>
            Detail
        </button>
        <button id="paymentButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-circle-dollar-to-slot"></i>
            Bayar
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
        <table class="table table-striped table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Kode Cust</th>
                    <th>Nama Cust</th>
                    <th>Jatuh Tempo</th>
                    <th>Total Harga</th>
                    <th>Total Sudah Bayar</th>
                    <th>Sisa Piutang</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
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

    $('input').on('change paste keyup', function(){
        refreshData();
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData() {
        var invoice_no = $('input[name=invoice_no]').val();
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        var payment_type = $('select[name=payment_type]').val();
        $.ajax({
            url: '{{ url('api/invoice/piutang') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: invoice_no,
                date_start: date_start,
                date_end: date_end,
                customer_code: customer_code,
                payment_type: payment_type,
            }
        })
        .done(function(result) {
            $('#itemsTable tbody').html('');
            $.each(result, function(index, val) {
                $('#itemsTable tbody').append('<tr data-id="'+val.invoice_no+'">' +
                    '<td>'+val.invoice_no+'</td>' +
                    '<td>'+val.invoice_date+'</td>' +
                    '<td>'+val.customer_code+'</td>' +
                    '<td>'+val.customer_name+'</td>' +
                    '<td>'+val.expiry_date+'</td>' +
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '<td>'+$.number(val.total_paid_amount, 0)+'</td>' +
                    '<td class="fw-bold">'+$.number(val.piutang, 0)+'</td>' +
                    '</tr>');
            });
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(result) {
            console.log(result);
            console.log("complete");
        });
    }

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/penjualan/invoice/detail') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });

    $('#paymentButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/penjualan/pembayaran/invoice') }}/'+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });
</script>
@endsection