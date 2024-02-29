@extends('admin/print/template')
@section('content')
<?php 
$start_periode = date('d/m/Y', strtotime(request()->date_start)); 
$end_periode = date('d/m/Y', strtotime(request()->date_end));
?>
    <h1>Laporan Jenis Barang</h1>
    <b>Kode Jenis Barang : {{ request()->type_code }}</b><br>
    <b>Periode : {{ $start_periode }} - {{ $end_periode }}</b><br>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>{{ (request()->kategori === 'penjualan') ? 'Nama Customer' : 'Nama Supplier' }}</th>
                <th>Harga</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ number_format($row->harga, 0) }}</td>
                <td>{{ number_format($row->qty, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection