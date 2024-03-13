@extends('admin.template')

@section('meta')
<title>Penjualan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-invoice-dollar"></i> &nbsp; Invoice
</a>
<a href="{{ url('admin/penjualan/invoice/list') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/invoice-list.svg') }}"> &nbsp; List Invoice
</a>
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-10">
        <div class="row">
            <div class="col-3">No. Invoice</div>
            <div class="col-7">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Tanggal Invoice</div>
            <div class="col-3">
                <input type="date" class="form-control" name="date_start">
            </div>
            <div class="col-1">
                s/d
            </div>
            <div class="col-3">
                <input type="date" class="form-control" name="date_end">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Kode Customer</div>
            <div class="col-3">
                <select name="customer_code" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($customers as $row)
                    <option value="{{ $row->customer_code }}">{{ $row->customer_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="customer_code_name" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($customers as $row)
                    <option value="{{ $row->customer_code }}">{{ $row->customer_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col text-end">
        {{-- <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
        <a href="{{ url('admin/pembelian/invoice/detail') }}" class="btn btn-danger btn-icon-lg">
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
        </button> --}}
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
                    <th>Dibuat Oleh</th>
                    <th colspan="2">Nama Supplier</th>
                    <th>Jatuh Tempo</th>
                    <th>Qty Beli</th>
                    <th>Qty Retur</th>
                    <th>Total Invoice</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                {{-- @foreach ($invoices as $row)
                <tr data-id="{{ $row->invoice_no }}">
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->supplier_code }}</td>
                    <td>{{ $row->supplier_name }}</td>
                    <td>{{ $row->expiry_date }}</td>
                    <td>{{ number_format($row->total_qty, 0) }}</td>
                    <td>{{ number_format($row->total_price, 0) }}</td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    $('select').on('change', function(){
        refreshData();
    });
    $('input').on('change keyup', function(){
        refreshData();
    });
    function refreshData() {
        $.ajax({
            url: '{{ url('api/penjualan/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: $('input[name=invoice_no]').val(),
                date_start: $('input[name=date_start]').val(),
                date_end: $('input[name=date_end]').val(),
                customer_code: $('select[name=customer_code]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            var total_price = 0;
            $('tbody').html('').addClass('selectable');
            $.each(result, function(index, val) {
                total_price = total_price + parseInt(val.total_invoice_price || 0);
                var inv_date = new Date(val.invoice_date);
                var exp_date = new Date(val.expiry_date);
                var createdBy = val.created_by !== null ? val.created_by : '';
                var newRow = '<tr data-id="'+val.invoice_no+'">'+
                    '<td>'+val.invoice_no+'</td>'+
                    '<td>'+inv_date.toString('dd-MM-yyyy')+'</td>'+
                    '<td>'+createdBy+'</td>'+
                    '<td>'+val.customer_code+'</td>'+
                    '<td>'+val.customer_name+'</td>'+
                    '<td>'+exp_date.toString('dd-MM-yyyy')+'</td>'+
                    '<td>'+val.total_qty+'</td>'+
                    '<td>'+val.total_retur_qty+'</td>'+
                    '<td>'+$.number(val.total_invoice_price, 0)+'</td>'+
                    '</tr>';
                $('tbody').append(newRow);
                $('input[name=total_price]').val($.number(total_price, 0));
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/penjualan/invoice/detail') }}?invoice_no="+selected_row;
    });
</script>
@endsection