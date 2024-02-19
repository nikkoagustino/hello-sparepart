@extends('admin.template')

@section('meta')
<title>Tambah Supplier - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/supplier') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/supplier.svg') }}"> &nbsp; Supplier
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/supplier/add') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Kode Supplier
                </div>
                <div class="col-8">
                    <input name="supplier_code" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Nama Supplier
                </div>
                <div class="col-8">
                    <input name="supplier_name" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Alamat
                </div>
                <div class="col-8">
                    <textarea name="address" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Telepon 1
                </div>
                <div class="col-8">
                    <input name="phone_number_1" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Telepon 2
                </div>
                <div class="col-8">
                    <input name="phone_number_2" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Contact Person
                </div>
                <div class="col-8">
                    <input name="contact_person" type="text" class="form-control">
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