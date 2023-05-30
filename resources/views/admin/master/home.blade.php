@extends('admin.template')

@section('meta')
<title>Master - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <i class="fa-solid fa-gear"></i> &nbsp; Master
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ url('admin/master/product') }}" class="btn btn-selection btn-purple">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/produk.svg') }}" class="icon-lg" alt="">
                    Produk
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/supplier') }}" class="btn btn-selection btn-pink">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-truck-fast"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/supplier.svg') }}" class="icon-lg" alt="">
                    Supplier
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/customer') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-network-wired"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/customer.svg') }}" class="icon-lg" alt="">
                    Customer
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <a href="{{ url('admin/master/sales') }}" class="btn btn-selection btn-yellow">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-headset"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/sales.svg') }}" class="icon-lg" alt="">
                    Sales
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/product-type') }}" class="btn btn-selection btn-red">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-barcode"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/jenis-barang.svg') }}" class="icon-lg" alt="">
                    Jenis Barang
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/vbelt') }}" class="btn btn-selection btn-green">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-infinity"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/vbelt.svg') }}" class="icon-lg" alt="">
                    V-Belt
                </a>
            </div>
        </div>
    </div>
</div>
@endsection