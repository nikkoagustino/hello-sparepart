@extends('admin/print/template')
@section('content')
    <table class="table table-striped print">
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
@endsection