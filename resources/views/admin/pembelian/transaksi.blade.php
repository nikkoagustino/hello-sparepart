@extends('admin.template')

@section('meta')
<title>List Transaksi - {{ config('app.name') }}</title>
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
            <div class="col-3">No. Invoice</div>
            <div class="col-7">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
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
        <div class="row mt-2">
            <div class="col-3">Kode Supplier</div>
            <div class="col-3">
                <select name="supplier_code" required="required" class="form-select form-control">
                    <option value="" selected="selected"></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="supplier_code_name" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_name }}</option>
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
    $('input').on('change keyup', function() {
        refreshData();
    });
    $('select').on('change', function() {
        refreshData();
    });

    function refreshData() {
        var invoice_no = $('input[name=invoice_no]').val();
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var supplier_code = $('select[name=supplier_code]').val();
        $.ajax({
            url: '{{ url('api/pembelian/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: invoice_no,
                date_start: date_start,
                date_end: date_end,
                supplier_code: supplier_code,
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
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '</tr>');
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/pembelian/transaksi/detail') }}?invoice_no="+selected_row;
    });

    $('#printButton').on('click', function(){
        const params = new URLSearchParams({
            invoice_no : $('input[name=invoice_no]').val(),
            date_start : $('input[name=date_start]').val(),
            date_end : $('input[name=date_end]').val(),
            supplier_code : $('select[name=supplier_code]').val(),
        });
        window.open('{{ url('admin/print/transaksi-pembelian') }}?'+params, 'printWindow');
    });

</script>
@endsection