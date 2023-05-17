@extends('admin.template')

@section('meta')
<title>List Supplier - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <i class="fa-solid fa-gear"></i> &nbsp; Master
</a>
<a href="{{ url('admin/master/supplier') }}" class="btn btn-danger">
    <i class="fa-solid fa-truck-fast"></i> &nbsp; Supplier
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
        <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-arrow-pointer"></i>
            Detail
        </button>
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped table-condensed selectable">
            <thead>
                <tr>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Contact Person</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $row)
                <tr data-id="{{ $row->supplier_code }}">
                    <td>{{ $row->supplier_code }}</td>
                    <td>{{ $row->supplier_name }}</td>
                    <td>{{ $row->contact_person }}</td>
                    <td>{{ $row->phone_number_1 }}</td>
                    <td>{{ $row->phone_number_2 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/supplier/add') }}';
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/master/supplier/detail') }}/'+selected_row;
        } else {
            alert('Pilih Supplier Terlebih Dahulu');
        }
    });
</script>
@endsection