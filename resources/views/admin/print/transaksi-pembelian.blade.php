@extends('admin/print/template')
@section('content')
@php
$start_date = request()->date_start ?? config('user.MIN_YEAR').'/01/01';
$end_date = request()->date_end ?? date('Y-m-d');
@endphp
    <h1>List Transaksi Pembelian</h1>
    <table style="font-weight: bold">
        <tr>
            <td>Periode : {{ date('d/m/Y', strtotime($start_date)) }} - {{ date('d/m/Y', strtotime($end_date)) }}</td>
        </tr>
    </table>    
    <br>
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tgl. Invoice</th>
                <th>Nama Supplier</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $row)
            <tr>
                <td>{{ $row->invoice_no }}</td>
                <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                <td>{{ $row->supplier_code }} &nbsp; {{ $row->supplier_name }}</td>
                <td>{{ number_format($row->total_price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection