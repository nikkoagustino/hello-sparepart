@extends('admin.template')

@section('meta')
<title>Transaksi Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
</a>
<a href="{{ url('admin/account/sales/transaksi') }}" class="btn btn-danger">
    <i class="fa-solid fa-cash-register"></i> &nbsp; Transaksi
</a>
@endsection
@section('content')
<form action="{{ url('admin/account/sales/transaksi/new') }}" method="POST">
    @csrf
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-2 pt-2">
                Kode Sales
            </div>
            <div class="col-5">
                <input type="text" name="sales_code" value="{{ $sales->sales_code }}" class="form-control" readonly="readonly">
            </div>
            <div class="col-5">
                <input type="text" name="sales_name" value="{{ $sales->sales_name }}" class="form-control" readonly="readonly">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2 pt-2">
                Tanggal
            </div>
            <div class="col-5">
                <input type="date" name="tx_date" value="{{ date('Y-m-d') }}" required="required" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2 pt-2">
                Total
            </div>
            <div class="col-5">
                <input type="text" name="amount" data-type="number" required="required" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2 pt-2">
                Keterangan
            </div>
            <div class="col-10">
                <textarea name="description" rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button class="btn btn-danger btn-icon-lg">
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