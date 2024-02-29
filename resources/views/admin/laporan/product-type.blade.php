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
                <div class="col-3">Jenis Barang</div>
                <div class="col-3">
                    <select name="type_code" required="required" class="form-select form-control">
                        <option value="" selected="selected"></option>
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select name="type_code_name" required="required" class="form-select form-control">
                        <option value="" selected="selected"></option>
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">Kategori</div>
                <div class="col-3">
                    <select name="kategori" class="form-control form-select">
                        <option value=""></option>
                        <option value="pembelian">PEMBELIAN</option>
                        <option value="penjualan">PENJUALAN</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="penjualanTable" style="display: none">
        <div class="row mt-3">
            <div class="col">
                <table class="table table-striped print table-condensed">
                    <thead>
                        <tr>
                            <th style="width: 41.5%">Nama Customer</th>
                            <th style="width: 16.6%">Modal</th>
                            <th style="width: 16.6%">Harga Jual</th>
                            <th style="width: 8.3%">Qty</th>
                            <th style="width: 16.6%">Laba</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-5"><b>Total</b></div>
            <div class="col-2">
                <input type="text" readonly="readonly" name="total_modal" class="form-control bg-khaki">
            </div>
            <div class="col-2">
                <input type="text" readonly="readonly" name="total_jual" class="form-control bg-khaki">
            </div>
            <div class="col-1"></div>
            <div class="col-2">
                <input type="text" readonly="readonly" name="total_laba" class="form-control bg-khaki">
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table class="table table-striped print table-condensed">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th class="header_nama">Nama Supplier</th>
                        <th>Harga</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button>
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
        var type_code = $('select[name=type_code]').val();
        var kategori = $('select[name=kategori]').val();
        if (date_start && date_end && type_code && kategori) {
            $.ajax({
                url: '{{ url('api/laporan/rekap-jenis-barang') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    date_start: date_start,
                    date_end: date_end,
                    type_code: type_code,
                    kategori: kategori,
                },
            })
            .done(function(result) {
                $('tbody').html('');
                $.each(result.data, function(index, val) {
                    var newRow = '<tr>'+
                                '<td>'+val.product_code+'</td>'+
                                '<td>'+val.product_name+'</td>'+
                                '<td>'+val.nama+'</td>'+
                                '<td>'+$.number((parseInt(val.harga) * parseInt(val.qty)), 0)+'</td>'+
                                '<td>'+val.qty+'</td>'+
                                '</tr>';
                    $('tbody').append(newRow);
                });

                var kategori = $('select[name=kategori]').val();
                if (kategori === 'penjualan') {
                    $('.header_nama').text('Nama Customer');
                } else if (kategori === 'pembelian') {
                    $('.header_nama').text('Nama Supplier');
                }
            });
        }
    }

    $('#printButton').on('click', function(){
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var type_code = $('select[name=type_code]').val();
        var kategori = $('select[name=kategori]').val();
        var query = new URLSearchParams({
            date_start: date_start,
            date_end: date_end,
            type_code: type_code,
            kategori: kategori,
        });
        if (date_start && date_end && type_code && kategori) {
            window.open('{{ url('admin/print/laporan-jenis-barang') }}?'+query.toString(), 'printWindow');
        } else {
            alert('Pilihan belum lengkap');
        }
    });
</script>
@endsection