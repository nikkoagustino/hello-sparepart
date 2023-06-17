@extends('admin/print/template')
@section('content')
    <table class="table table-striped print">
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
@endsection