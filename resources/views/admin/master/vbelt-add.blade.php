@extends('admin.template')

@section('meta')
<title>Tambah V-Belt - {{ env('APP_NAME') }}</title>
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
            <div class="row mb-2">
                <div class="col-4">
                    Model
                </div>
                <div class="col-8">
                    <input name="model" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Ukuran
                </div>
                <div class="col-4">
                    <input type="number" name="size_min" required="required" class="form-control">
                </div>
                <div class="col-4">
                    Min
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                </div>
                <div class="col-4">
                    <input type="number" name="size_max" required="required" class="form-control">
                </div>
                <div class="col-4">
                    Max
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Harga
                </div>
                <div class="col-8">
                    <input data-type="number" name="price" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Discount
                </div>
                <div class="col-7">
                    <input name="discount" type="number" class="form-control" step="0.01" value="0.00">
                </div>
                <div class="col-1">%</div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    INCH/PCS
                </div>
                <div class="col-8">
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