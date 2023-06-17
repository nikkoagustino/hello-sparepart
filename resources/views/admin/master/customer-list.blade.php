@extends('admin.template')

@section('meta')
<title>List Customer - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/customer') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/customer.svg') }}"> &nbsp; Customer
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
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Kode Customer</th>
                    <th>Nama Customer</th>
                    <th>Limit</th>
                    <th>Contact Person</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $row)
                <tr data-id="{{ $row->customer_code }}">
                    <td>{{ $row->customer_code }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ number_format($row->limit, 0) }}</td>
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
    var selected_row;

    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/customer/add') }}';
    });

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/master/customer/detail') }}/'+selected_row;
        } else {
            alert('Pilih Customer Terlebih Dahulu');
        }
    });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/customer') }}', 'printWindow');
    });
</script>
@endsection