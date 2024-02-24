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
                <div class="col-3">
                    Kode Produk
                </div>
                <div class="col-6">
                    <input name="product_code" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Nama Produk
                </div>
                <div class="col-6">
                    <input name="product_name" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Harga Modal
                </div>
                <div class="col-3">
                    <input name="price_capital" type="text" data-type="number" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Harga Jual
                </div>
                <div class="col-3">
                    <input name="price_selling" type="text" data-type="number" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Jenis Barang
                </div>
                <div class="col-3">
                    <select name="type_code" required="required" class="form-select form-control">
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select name="type_code_name" required="required" class="form-select form-control">
                        @foreach ($product_types as $row)
                        <option value="{{ $row->type_code }}">{{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Qty
                </div>
                <div class="col-3">
                    <input name="qty_stok" value="0" type="text" data-type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-4 text-end">
            <button id="saveButton" type="submit" class="btn btn-danger btn-icon-lg">
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