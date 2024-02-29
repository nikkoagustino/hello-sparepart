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
    </div>

    @include('shared.tabs-laporan')

    <div class="row mt-5">
        <div class="col-10">
            <div class="row mt-2">
                <div class="col-3">Periode</div>
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
                <div class="col-3">Nama Customer</div>
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
            <table class="table table-striped print table-condensed">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga / pc</th>
                        <th>Disc (%)</th>
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
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row px-3">
    <div class="col">
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button>
    </div>
    <div class="col-1">
        Total
    </div>
    <div class="col-2 text-end">
        <input type="text" name="total" class="form-control bg-khaki text-end" readonly="readonly">
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
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        if (date_start && date_end && customer_code) {
            $.ajax({
                url: '{{ url('api/laporan/rekap-customer') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    date_start: date_start,
                    date_end: date_end,
                    customer_code: customer_code,
                },
            })
            .done(function(result) {
                var total = 0;
                $('tbody').html('');
                $.each(result.data, function(index, val) {
                    total = total + parseInt(val.subtotal_price);
                    var newRow = '<tr>'+
                                '<td>'+val.product_code+'</td>'+
                                '<td>'+val.type_code+'</td>'+
                                '<td>'+val.product_name+'</td>'+
                                '<td>'+val.qty+'</td>'+
                                '<td>'+$.number(val.normal_price, 0)+'</td>'+
                                '<td>'+$.number(val.discount_rate, 2)+'</td>'+
                                '<td>'+$.number(val.subtotal_price, 0)+'</td>'+
                                '</tr>';
                    $('tbody').append(newRow);
                });
                $('input[name=total]').val($.number(total, 0));
            });
        }
    }

    $('#printButton').on('click', function(){
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var customer_code = $('select[name=customer_code]').val();
        var query = new URLSearchParams({
            date_start: date_start,
            date_end: date_end,
            customer_code: customer_code,
        });
        if (date_start && date_end && customer_code) {
            window.open('{{ url('admin/print/laporan-customer') }}?'+query.toString(), 'printWindow');
        } else {
            alert('Pilihan belum lengkap');
        }
    });
</script>
@endsection