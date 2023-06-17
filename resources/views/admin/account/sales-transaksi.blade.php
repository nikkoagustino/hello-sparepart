@extends('admin.template')

@section('meta')
<title>Transaksi Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
</a>
<a href="{{ url('admin/account/sales/transaksi') }}" class="btn btn-danger">
    <i class="fa-solid fa-cash-register"></i> &nbsp; Transaksi
</a>
@endsection
@section('content')
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-2 pt-2">
                Kode Sales
            </div>
            <div class="col">
                <select name="sales_code" required="required" class="form-select form-control">
                    <option value="" selected="selected">All Sales...</option>
                    @foreach ($sales as $row)
                    <option value="{{ $row->sales_code }}">{{ $row->sales_code }} - {{ $row->sales_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2 pt-2">
                Bulan
            </div>
            <div class="col-4">
                <select name="month" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    <option value="1">JANUARI</option>
                    <option value="2">FEBRUARI</option>
                    <option value="3">MARET</option>
                    <option value="4">APRIL</option>
                    <option value="5">MEI</option>
                    <option value="6">JUNI</option>
                    <option value="7">JULI</option>
                    <option value="8">AGUSTUS</option>
                    <option value="9">SEPTEMBER</option>
                    <option value="10">OKTOBER</option>
                    <option value="11">NOVEMBER</option>
                    <option value="12">DESEMBER</option>
                </select>
            </div>
            <div class="col-2 pt-2">
                Tahun
            </div>
            <div class="col-4">
                <input class="form-control" name="year" type="number" step="1" min="2000" max="2100" value="{{ date('Y') }}">
            </div>
        </div>
    </div>
    <div class="col-4 text-end">
        <a href="javascript:void(0)" onclick="newButton()" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus-circle"></i>
            New
        </a>
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
<div class="row mt-4">
    <div class="col">
        <table class="table table-striped print selectable" id="invoice_table">
            <thead>
                <tr>
                    <th>Kode Sales</th>
                    <th>Nama Sales</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div class="row mt-2">
    <div class="col-4">
        <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-save"></i>
            Save
        </button>
        <button id="editButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
    </div>
    <div class="col-4">
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-4">
                Total Invoice
            </div>
            <div class="col">
                <input type="text" data-type="number" name="total_invoice" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        refreshData();
    });
    function newButton() {
        var sales_code = $('select[name=sales_code]').val();
        if (!sales_code) {
            alert('Pilih sales terlebih dahulu');
            return;
        }
        window.location.href = "{{ url('admin/account/sales/transaksi/new') }}?sales_code="+sales_code; 
    }

    $('select').on('change', function(){
        refreshData();
    });
    $('input[name=year]').on('change', function(){
        refreshData();
    });

    function refreshData(){
        var sales_code = $('select[name=sales_code]').val();
        var year = $('input[name=year]').val();
        var month = $('select[name=month]').val();
        $.ajax({
            url: '{{ url('api/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                sales_code: sales_code,
                year: year,
                month: month
            },
        })
        .done(function(result) {
            processData(result);
        });
    }


    function processData(result) {
        var total_invoice_price = 0;
        var table_row = '';
        $.each(result, function(index, row) {
            table_row += '<tr data-id="'+row.id+'">' +
                '<td>'+row.sales_code+'</td>' +
                '<td>'+row.sales_name+'</td>' +
                '<td>'+row.tx_date+'</td>' +
                '<td>'+row.expense_type+'</td>' +
                '<td>'+$.number(row.amount, 0)+'</td>' +
                '</tr>';
                total_invoice_price = total_invoice_price + parseInt(row.amount);
        });
        $('#invoice_table tbody').html(table_row);
        $('input[name=total_invoice]').val(total_invoice_price).change();
    }

    function enableEdit() {
        window.location.href = "{{ url('admin/account/sales/transaksi/edit') }}/"+selected_row;
    }
</script>
@endsection