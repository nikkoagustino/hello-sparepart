@extends('admin.template')

@section('meta')
<title>Invoice - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <i class="fa-solid fa-boxes"></i> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/invoice/list') }}" class="btn btn-selection btn-pink">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-download"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/penjualan.svg') }}" class="icon-lg" alt="">
                    Penjualan
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice/list') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-upload"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/pembelian.svg') }}" class="icon-lg" alt="">
                    Pembelian
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection