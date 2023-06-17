@extends('admin/print/template')
@section('content')
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $row)
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->product_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection