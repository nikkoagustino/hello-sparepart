@extends('admin/print/template')
@section('content')
    <h1>Database Customer</h1>
    <table class="table table-striped">
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
@endsection