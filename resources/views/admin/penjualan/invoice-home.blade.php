@extends('admin.template')

@section('meta')
<title>Penjualan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-invoice-dollar"></i> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/invoice/new') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    {{-- <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt=""> --}}
                    Invoice Baru
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/penjualan/invoice/list') }}" class="btn btn-selection btn-blue">
                    {{-- <span class="display-1">
                        <i class="fa-solid fa-receipt"></i>
                    </span> --}}
                    {{-- <img src="{{ url('assets/img/icon/invoice.svg') }}" class="icon-lg" alt="">
                    List Invoice --}}
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
        window.location.href = '{{ url('admin/penjualan/invoice/new') }}';
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/penjualan/invoice/detail') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });

    @if (session('is_print') === 1)
    window.open('{{ url('admin/print/invoice-sell') }}?invoice_no={{ session('invoice_no') }}', 'printWindow');
    @endif
</script>
@endsection