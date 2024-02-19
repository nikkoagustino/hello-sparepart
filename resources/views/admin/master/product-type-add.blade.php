@extends('admin.template')

@section('meta')
<title>Tambah Jenis Barang - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product-type') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/jenis-barang.svg') }}"> &nbsp; Jenis Barang
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/product-type/add') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Kode Barang
                </div>
                <div class="col-8">
                    <input name="type_code" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Jenis Barang
                </div>
                <div class="col-8">
                    <input name="type_name" required="required" type="text" class="form-control">
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