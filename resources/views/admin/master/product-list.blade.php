@extends('admin.template')

@section('meta')
<title>List Produk - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-product.svg') }}"> &nbsp; Produk
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
        <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-arrow-pointer"></i>
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
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kode Jenis Barang</th>
                    <th>Nama Jenis Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $row)
                <tr data-id="{{ $row->product_code }}">
                    <td>{{ $row->product_code }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->type_code }}</td>
                    <td>{{ $row->type_name }}</td>
                    <td>{{ number_format($row->price_capital, 0) }}</td>
                    <td>{{ number_format($row->price_selling, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/product/add') }}';
    });
    
    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/master/product/detail') }}/'+selected_row;
        } else {
            alert('Pilih Jenis Barang Terlebih Dahulu');
        }
    });
</script>
@endsection