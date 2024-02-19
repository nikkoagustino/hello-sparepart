@extends('admin/template')
@section('meta')
<title>Laba Rugi - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}"> &nbsp; Laporan
</a>
<a href="{{ url('admin/laporan/laba-rugi') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/laba-rugi.svg') }}"> &nbsp; Laba Rugi
</a>
@endsection
@section('content')

<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ url('admin/laporan/laba-rugi/tahun') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-calendar"></i>
                    </span> 
                    Tahunan
                </a>
            </div>
            <div class="col">
                <a href="{{ url('admin/laporan/laba-rugi/bulan') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-calendar"></i>
                    </span> 
                    Bulanan
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection