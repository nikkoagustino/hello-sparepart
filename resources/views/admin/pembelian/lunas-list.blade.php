@extends('admin.template')

@section('meta')
<title>List Lunas - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Penjualan
</a>
<a href="{{ url('admin/pembelian/lunas') }}" class="btn btn-danger">
    <i class="fa-solid fa-check-to-slot"></i> &nbsp; Lunas
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
                Kode Supplier
            </div>
            <div class="col-9">
                <select name="supplier_code" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled">Pilih Supplier...</option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_code }} - {{ $row->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-file"></i>
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
        <table class="table table-striped print table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Kode Cust</th>
                    <th>Nama Cust</th>
                    <th>Jatuh Tempo</th>
                    <th>Total Harga</th>
                    <th>Total Sudah Bayar</th>
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
        var supplier_code = $('select[name=supplier_code]').val();
        var payment_type = $('select[name=payment_type]').val();
        $.ajax({
            url: '{{ url('api/invoice/pembelian/lunas') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: invoice_no,
                date_start: date_start,
                date_end: date_end,
                supplier_code: supplier_code,
                payment_type: payment_type,
            }
        })
        .done(function(result) {
            $('#itemsTable tbody').html('');
            $.each(result, function(index, val) {
                $('#itemsTable tbody').append('<tr data-id="'+val.invoice_no+'">' +
                    '<td>'+val.invoice_no+'</td>' +
                    '<td>'+val.invoice_date+'</td>' +
                    '<td>'+val.supplier_code+'</td>' +
                    '<td>'+val.supplier_name+'</td>' +
                    '<td>'+val.expiry_date+'</td>' +
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '<td>'+$.number(val.total_paid_amount, 0)+'</td>' +
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
            window.location.href='{{ url('admin/pembelian/invoice/detail') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });
    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/buy-lunas-list') }}', 'printWindow');
    });
</script>
@endsection