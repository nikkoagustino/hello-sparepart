@extends('admin.template')

@section('meta')
<title>Laporan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}"> &nbsp; Laporan
</a>
@endsection
@section('content')
<div class="container-fluid p-3">
    <div class="row">
        <div class="col"><h3>LAPORAN</h3></div>
        <div class="col-1">
            Periode
        </div>
        <div class="col-3">
            @include('shared.select-month')
        </div>
        <div class="col-2">
            @include('shared.select-year')
        </div>
    </div>

    @include('shared.tabs-laporan')

    <div class="row mt-5">
        <div class="col-10">
            {{-- <div class="row">
                <div class="col-3">No. Invoice</div>
                <div class="col-7">
                    <input type="text" name="invoice_no" class="form-control">
                </div>
            </div> --}}
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
                        <option value="" selected="selected"></option>
                        @foreach ($customers as $row)
                        <option value="{{ $row->customer_code }}">{{ $row->customer_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select name="customer_code_name" required="required" class="form-select form-control">
                        <option value="" selected="selected"></option>
                        @foreach ($customers as $row)
                        <option value="{{ $row->customer_code }}">{{ $row->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table class="table table-striped print table-condensed selectable">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tgl. Invoice</th>
                        <th>Jatuh Tempo</th>
                        <th>Nama Customer</th>
                        <th>Status</th>
                        <th>Total</th>
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
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
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
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <button id="printButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
        </div>
        <div class="col-1">Total</div>
        <div class="col-3"><input type="text" readonly="readonly" name="total_price" class="form-control bg-khaki"></div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('input').on('change', function(){
        refreshData();
    });
    $('select').on('change', function(){
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
                total_price = total_price + parseInt(val.total_invoice_price);
                var inv_date = new Date(val.invoice_date);
                var exp_date = new Date(val.expiry_date);
                var newRow = '<tr data-id="'+val.invoice_no+'">'+
                    '<td>'+val.invoice_no+'</td>'+
                    '<td>'+inv_date.toString('dd-MM-yyyy')+'</td>'+
                    '<td>'+exp_date.toString('dd-MM-yyyy')+'</td>'+
                    '<td>'+val.customer_name+'</td>'+
                    '<td>'+val.payment_type+'</td>'+
                    '<td>'+$.number(val.total_invoice_price, 0)+'</td>'+
                    '</tr>';
                $('tbody').append(newRow);
                $('input[name=total_price]').val($.number(total_price, 0));
            });
        });
    }

    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        var query = new URLSearchParams({
            'date_start': date_start,
            'date_end': date_end,
            'customer_code': customer_code,
        });
        window.open('{{ url('admin/print/transaksi-penjualan') }}?'+query.toString(), 'printWindow');
    });
</script>
@endsection