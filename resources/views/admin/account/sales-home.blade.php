@extends('admin.template')

@section('meta')
<title>Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/account/sales/transaksi') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-cash-register"></i>
                    </span>
                    Transaksi
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/account/sales/komisi') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-dollar"></i>
                    </span>
                    Komisi
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection