@extends('admin.template')

@section('meta')
<title>Penjualan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col-4">
                <a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    Invoice
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/piutang') }}" class="btn btn-selection btn-yellow">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/svg/piutang.svg') }}" class="icon-lg" alt="">
                    Piutang
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/transaksi') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-cash-register"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/svg/transaksi.svg') }}" class="icon-lg" alt="">
                    Transaksi
                </a>
            </div> 
           {{--  <div class="col-4">
                <a href="{{ url('admin/penjualan/pembayaran') }}" class="btn btn-selection btn-red">
                    <span class="display-1">
                        <i class="fa-solid fa-circle-dollar-to-slot"></i>
                    </span>
                    <img src="{{ url('assets/img/svg/pembayaran.svg') }}" class="icon-lg" alt="">
                    Pembayaran
                </a>
            </div> --}}
            {{-- <div class="col-4">
                <a href="{{ url('admin/penjualan/lunas') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-check-to-slot"></i>
                    </span>
                    Lunas
                </a>
            </div> --}}
        </div>
        <div class="row mb-5">
            <div class="col-4">
                <a href="{{ url('admin/penjualan/retur') }}" class="btn btn-selection btn-pink">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/svg/retur.svg') }}" class="icon-lg" alt="">
                    Retur
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection