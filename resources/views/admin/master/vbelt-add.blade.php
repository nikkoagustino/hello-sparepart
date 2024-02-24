@extends('admin.template')

@section('meta')
<title>Tambah V-Belt - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/vbelt') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/vbelt.svg') }}"> &nbsp; V-Belt
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/vbelt/add') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-3">
                    Jenis Barang
                </div>
                <div class="col-4">
                    <input type="text" name="type_code" required="required" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Model
                </div>
                <div class="col-4">
                    <input name="model" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Ukuran
                </div>
                <div class="col-2">
                    <input type="number" name="size_min" required="required" class="form-control">
                </div>
                <div class="col-2">
                    Min
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                </div>
                <div class="col-2">
                    <input type="number" name="size_max" required="required" class="form-control">
                </div>
                <div class="col-2">
                    Max
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Harga
                </div>
                <div class="col-3">
                    <input data-type="number" name="price" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Discount
                </div>
                <div class="col-3">
                    <input name="discount" type="number" class="form-control" step="0.01" value="0.00">
                </div>
                <div class="col-1">%</div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    INCH/PCS
                </div>
                <div class="col-3">
                    <select name="price_unit" class="form-select form-control" required="required">
                        <option value="" disabled="disabled" selected="selected">Pilih INCH/PCS...</option>
                        <option value="INCH">INCH</option>
                        <option value="PCS">PCS</option>
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