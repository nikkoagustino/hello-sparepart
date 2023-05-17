@extends('admin.template')

@section('meta')
<title>List Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <i class="fa-solid fa-gear"></i> &nbsp; Master
</a>
<a href="{{ url('admin/master/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
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
                    <th>Kode Sales</th>
                    <th>Nama Sales</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $row)
                <tr data-id="{{ $row->sales_code }}">
                    <td>{{ $row->sales_code }}</td>
                    <td>{{ $row->sales_name }}</td>
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
        window.location.href = '{{ url('admin/master/sales/add') }}';
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/master/sales/detail') }}/'+selected_row;
        } else {
            alert('Pilih Sales Terlebih Dahulu');
        }
    });
</script>
@endsection