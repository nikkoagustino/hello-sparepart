@extends('admin/print/template')
@section('content')
    <h3>Invoice No: {{ $invoice->invoice_no }}</h3>
    <p>Supplier Code: {{ $invoice->supplier_code }}</p>
    <p>Supplier Name: {{ $invoice->supplier_name }}</p>
    <p>Tgl Invoice: {{ $invoice->invoice_date }}</p>
    <p>Jatuh Tempo: {{ $invoice->expiry_date }}</p>
    <p>Total: {{ number_format($invoice->total_price, 0) }}</p>
    <p>Status: {{ $invoice->payment_type }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga /pcs</th>
                <th>Disc (%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $row)
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ number_format($row->qty, 0) }}</td>
                <td>{{ number_format($row->normal_price, 0) }}</td>
                <td>{{ number_format($row->discount_rate, 2) }}</td>
                <td>{{ number_format($row->qty * (int) ($row->normal_price - ($row->normal_price * ($row->discount_rate / 100))), 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection