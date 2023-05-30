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
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-selection btn-purple">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt="">
                    Invoice
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/hutang') }}" class="btn btn-selection btn-yellow">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/hutang.svg') }}" class="icon-lg" alt="">
                    Hutang
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/pembayaran') }}" class="btn btn-selection btn-red">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-circle-dollar-to-slot"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/pembayaran.svg') }}" class="icon-lg" alt="">
                    Pembayaran
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/transaksi') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-cash-register"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/transaksi.svg') }}" class="icon-lg" alt="">
                    Transaksi
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/retur') }}" class="btn btn-selection btn-pink">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/retur.svg') }}" class="icon-lg" alt="">
                    Retur
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection