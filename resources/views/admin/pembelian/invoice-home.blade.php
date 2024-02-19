@extends('admin.template')

@section('meta')
<title>Pembelian - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/invoice-list.svg') }}"> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice/new') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    {{-- <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt=""> --}}
                    Invoice Baru
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice/list') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-receipt"></i>
                    </span> --}}
                    {{-- <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt=""> --}}
                    <img src="{{ url('assets/img/svg/invoice-list.svg') }}" class="icon-lg"> &nbsp; List Invoice
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var selected_row;

    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/pembelian/invoice/new') }}';
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/pembelian/invoice/detail') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });
</script>
@endsection