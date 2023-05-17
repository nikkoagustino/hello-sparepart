@extends('admin.template')

@section('meta')
<title>Pembelian - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Pembelian
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col-4">
                <a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </span>
                    Invoice
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-download"></i>
                    </span>
                    Penjualan
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-upload"></i>
                    </span>
                    Pembelian
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-4">
                <a href="{{ url('admin/pembelian/hutang') }}" class="btn btn-selection btn-yellow">
                    <span class="display-1">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </span>
                    Hutang
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/piutang') }}" class="btn btn-selection btn-red">
                    <span class="display-1">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </span>
                    Piutang
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/laporan/laba-rugi') }}" class="btn btn-selection btn-green">
                    <span class="display-1">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </span>
                    Laporan Laba Rugi
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection