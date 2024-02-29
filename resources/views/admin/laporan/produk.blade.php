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
                <div class="col-3">Kode Produk</div>
                <div class="col-3">
                    <select name="product_code" required="required" class="form-select form-control">
                        <option value="" selected="selected"></option>
                        @foreach ($products as $row)
                        <option value="{{ $row->product_code }}">{{ $row->product_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select name="product_code_name" required="required" class="form-select form-control">
                        <option value="" selected="selected"></option>
                        @foreach ($products as $row)
                        <option value="{{ $row->product_code }}">{{ $row->product_name }}</option>
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
    <div id="pembelianTable" style="display: none">
        <div class="row mt-3">
            <div class="col">
                <table class="table table-striped print table-condensed">
                    <thead>
                        <tr>
                            <th style="width: 41.5%">Nama Supplier</th>
                            <th style="width: 16.6%">Harga Normal</th>
                            <th style="width: 16.6%">Diskon (%)</th>
                            <th style="width: 8.3%">Qty</th>
                            <th style="width: 16.6%">Harga Beli</th>
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
                <input type="text" readonly="readonly" name="total_harga_normal" class="form-control bg-khaki">
            </div>
            <div class="col-2">
                {{-- <input type="text" readonly="readonly" name="total_jual" class="form-control bg-khaki"> --}}
            </div>
            <div class="col-1"></div>
            <div class="col-2">
                <input type="text" readonly="readonly" name="total_harga_beli" class="form-control bg-khaki">
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
        var product_code = $('select[name=product_code]').val();
        var kategori = $('select[name=kategori]').val();
        if (date_start && date_end && product_code && kategori) {
            $.ajax({
                url: '{{ url('api/laporan/rekap-produk') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    date_start: date_start,
                    date_end: date_end,
                    product_code: product_code,
                    kategori: kategori,
                },
            })
            .done(function(result) {
                hideAllTable();
                var kategori = $('select[name=kategori]').val();
                if (kategori === 'penjualan') {
                    showPenjualanTable(result);
                } else if (kategori === 'pembelian') {
                    showPembelianTable(result);
                }
            });
        }
    }

    function hideAllTable() {
        $('#penjualanTable').hide();
        $('#pembelianTable').hide();
    }

    function showPenjualanTable(result) {
        $('#penjualanTable tbody').html('');

        var total_modal = 0;
        var total_jual = 0;
        var total_qty = 0;
        var total_laba = 0;
        $.each(result.data, function(index, val) {
            var subtotal = (val.harga_jual - val.modal) * val.qty;
            var modal = val.modal * val.qty;
            var harga_jual = val.harga_jual * val.qty;
            var newRow = '<tr>'+
                '<td>'+val.customer_name+'</td>'+
                '<td>'+$.number(modal, 0)+'</td>'+
                '<td>'+$.number(harga_jual, 0)+'</td>'+
                '<td>'+$.number(val.qty, 0)+'</td>'+
                '<td>'+$.number(subtotal, 0)+'</td>'+
                '</tr>';
            total_jual = total_jual + harga_jual;
            total_modal = total_modal + modal;
            total_laba = total_laba + subtotal;
            $('#penjualanTable tbody').append(newRow);
            $('input[name=total_jual]').val($.number(total_jual, 0));
            $('input[name=total_modal]').val($.number(total_modal, 0));
            $('input[name=total_laba]').val($.number(total_laba, 0));
        });

        $('#penjualanTable').show();
    }

    function showPembelianTable(result) {
        $('#pembelianTable tbody').html('');

        var total_harga_normal = 0;
        var total_harga_beli = 0;
        var total_qty = 0;
        var total_laba = 0;
        $.each(result.data, function(index, val) {
            var harga_normal = val.harga_normal * val.qty;
            var harga_beli = val.harga_beli * val.qty;
            var newRow = '<tr>'+
                '<td>'+val.supplier_name+'</td>'+
                '<td>'+$.number(harga_normal, 0)+'</td>'+
                '<td>'+$.number(val.discount, 2)+'</td>'+
                '<td>'+$.number(val.qty, 0)+'</td>'+
                '<td>'+$.number(harga_beli, 0)+'</td>'+
                '</tr>';
            total_harga_normal = total_harga_normal + harga_normal;
            total_harga_beli = total_harga_beli + harga_beli;
            $('#pembelianTable tbody').append(newRow);
            $('input[name=total_harga_beli]').val($.number(total_harga_beli, 0));
            $('input[name=total_harga_normal]').val($.number(total_harga_normal, 0));
        });

        $('#pembelianTable').show();
    }

    $('#printButton').on('click', function(){
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var product_code = $('select[name=product_code]').val();
        var kategori = $('select[name=kategori]').val();
        var query = new URLSearchParams({
            date_start: date_start,
            date_end: date_end,
            product_code: product_code,
            kategori: kategori,
        });
        if (date_start && date_end && product_code && kategori) {
            window.open('{{ url('admin/print/laporan-produk') }}?'+query.toString(), 'printWindow');
        } else {
            alert('Pilihan belum lengkap');
        }
    });
</script>
@endsection