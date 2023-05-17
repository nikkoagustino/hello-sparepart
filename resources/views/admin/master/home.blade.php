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
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ url('admin/master/product') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </span>
                    Produk
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/supplier') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-truck-fast"></i>
                    </span>
                    Supplier
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/customer') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-network-wired"></i>
                    </span>
                    Customer
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <a href="{{ url('admin/master/sales') }}" class="btn btn-selection btn-yellow">
                    <span class="display-1">
                        <i class="fa-solid fa-headset"></i>
                    </span>
                    Sales
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/product-type') }}" class="btn btn-selection btn-red">
                    <span class="display-1">
                        <i class="fa-solid fa-barcode"></i>
                    </span>
                    Jenis Barang
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/master/vbelt') }}" class="btn btn-selection btn-green">
                    <span class="display-1">
                        <i class="fa-solid fa-infinity"></i>
                    </span>
                    V-Belt
                </a>
            </div>
        </div>
    </div>
</div>
@endsection