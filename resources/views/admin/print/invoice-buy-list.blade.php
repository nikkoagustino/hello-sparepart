@extends('admin/print/template')
@section('content')
    <h1>List Invoice</h1>
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tanggal Invoice</th>
                <th>Supplier</th>
                <th>Jatuh Tempo</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $row)
            <tr>
                <td>{{ $row->invoice_no }}</td>
                <td>{{ $row->invoice_date }}</td>
                <td>{{ $row->supplier_name }}</td>
                <td>{{ $row->expiry_date }}</td>
                <td>{{ $row->total_qty }}</td>
                <td>{{ number_format($row->total_price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection