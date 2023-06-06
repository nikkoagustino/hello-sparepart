@extends('admin.template')

@section('meta')
<title>List V-Belt - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/vbelt') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/vbelt.svg') }}"> &nbsp; V-Belt
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
                    <th>Jenis</th>
                    <th>Model</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>INCH/PCS</th>
                    <th>Disc (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vbelts as $row)
                <tr data-id="{{ $row->id }}">
                    <td>{{ $row->type_code }}</td>
                    <td>{{ $row->model }}</td>
                    <td>{{ $row->size_min }} s/d {{ $row->size_max }}</td>
                    <td>{{ number_format($row->price, 0) }}</td>
                    <td>{{ $row->price_unit }}</td>
                    <td>{{ number_format($row->discount, 2) }}</td>
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
        window.location.href = '{{ url('admin/master/vbelt/add') }}';
    });
    
    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/master/vbelt/detail') }}/'+selected_row;
        } else {
            alert('Pilih V-Belt Terlebih Dahulu');
        }
    });
</script>
@endsection