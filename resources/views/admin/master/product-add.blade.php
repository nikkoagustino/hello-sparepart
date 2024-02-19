@extends('admin.template')

@section('meta')
<title>Tambah Produk - {{ config('app.name') }}</title>
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
<form action="{{ url('admin/master/product/add') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Kode Barang
                </div>
                <div class="col-8">
                    <input name="product_code" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Nama Barang
                </div>
                <div class="col-8">
                    <input name="product_name" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Harga Modal
                </div>
                <div class="col-8">
                    <input data-type="number" name="price_capital" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Harga Jual
                </div>
                <div class="col-8">
                    <input data-type="number" name="price_selling" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Jenis Barang
                </div>
                <div class="col-8">
                    <select name="type_code" required="required" class="form-select form-control">
                        <option value="" selected="selected" disabled="disabled">Pilih Tipe Produk...</option>
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_code }} - {{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="col-4 text-end">
            <button type="submit" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button>
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
</form>
@endsection