@extends('admin/template')
@section('meta')
<title>Laporan Jenis Barang - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Laporan
</a>
<a href="{{ url('admin/laporan/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/jenis-barang.svg') }}"> &nbsp; Jenis Barang
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col-3">
                    Periode
                </div>
                <div class="col-4">
                    <input type="date" name="date_start" class="form-control">
                </div>
                <div class="col-1">
                    s/d
                </div>
                <div class="col-4">
                    <input type="date" name="date_end" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    Kode Jenis Barang
                </div>
                <div class="col-9">
                    <select name="type_code" class="form-select form-control">
                        <option value="">Semua Jenis Barang...</option>
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_code }} - {{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4 text-end">
            <button onclick="refreshData()" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-refresh"></i>
                Refresh
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
</div>  
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Modal</th>
                    <th>Penjualan</th>
                    <th>Laba</th>
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
    function refreshData() {
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var type_code = $('select[name=type_code]').val();
        
        $.ajax({
            url: '{{ url('api/laporan/product-type') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                date_start: date_start,
                date_end: date_end,
                type_code: type_code,
            },
        })
        .done(function(result) {
            console.log(result.data);
            $('tbody').html('');
            var rows = '<tr><td>'+$.number(result.data.total_modal, 0)+'</td><td>'+$.number(result.data.total_penjualan, 0)+'</td><td>'+$.number(result.data.total_laba, 0)+'</td></tr>';
            $('tbody').html(rows);
        });
    }
</script>
@endsection