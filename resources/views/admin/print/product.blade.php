@extends('admin/print/template')
@section('content')
    <h1>Database Produk</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $row)
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ number_format($row->price_capital, 0) }}</td>
                <td>{{ number_format($row->price_selling, 0) }}</td>
                <td>{{ number_format($row->qty_stok, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection