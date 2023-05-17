@extends('admin.template')

@section('meta')
<title>Pembelian - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-invoice-dollar"></i> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice/new') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-circle-plus"></i>
                    </span>
                    Invoice Baru
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/pembelian/invoice/detail') }}" class="btn btn-selection btn-blue">
                    <span class="display-1">
                        <i class="fa-solid fa-receipt"></i>
                    </span>
                    List Invoice
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

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/invoice') }}');
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/pembelian/invoice/detail') }}/'+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });
</script>
@endsection