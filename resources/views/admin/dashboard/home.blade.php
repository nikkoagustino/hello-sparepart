@extends('admin.template')

@section('meta')
<title>Dashboard - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-dashboard.svg') }}"> &nbsp; Dashboard
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col-4">
                <a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-selection btn-purple">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt="">
                    Invoice
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/dashboard/hutang') }}" class="btn btn-selection btn-yellow">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/hutang.svg') }}" class="icon-lg" alt="">
                    Hutang
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/dashboard/piutang') }}" class="btn btn-selection btn-red">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </span> --}}
                    <img src="{{ url('assets/img/icon/piutang.svg') }}" class="icon-lg" alt="">
                    Piutang
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-4">
                <a href="{{ url('admin/dashboard/surat-jalan') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-motorcycle"></i>
                    </span>
                    {{-- <img src="{{ url('assets/img/icon/laporan-labarugi.svg') }}" class="icon-lg" alt=""> --}}
                    Surat Jalan
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/dashboard/laba-rugi') }}" class="btn btn-selection btn-green">
                    <span class="display-1">
                        <i class="fa-solid fa-chart-column"></i>
                    </span>
                    {{-- <img src="{{ url('assets/img/icon/laporan-labarugi.svg') }}" class="icon-lg" alt=""> --}}
                    Laporan Laba Rugi
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection