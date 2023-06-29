@extends('admin/print/template')
@section('content')
    <h1>List Transaksi: {{ $product_code }}</h1>
    <table class="table table-striped print">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tgl. Invoice</th>
                    <th>Status</th>
                    <th>Kode Supp / Cust</th>
                    <th>Nama Supp / Cust</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $row)
                <tr data-status="{{ $row->status }}" data-id="{{ $row->invoice_no }}">
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->cust_supp_code }}</td>
                    <td>{{ $row->cust_supp_name }}</td>
                    <td>{{ number_format($row->qty, 0) }}</td>
                    <td>{{ number_format($row->subtotal_price, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
    </table>
@endsection