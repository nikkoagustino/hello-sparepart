@extends('admin/print/template')
@section('content')
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product_types as $row)
            <tr data-id="{{ $row->type_code }}">
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->type_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection