@extends('admin/print/template')
@section('content')
@php
$start_date = request()->date_start ?? config('user.MIN_YEAR').'/01/01';
$end_date = request()->date_end ?? date('Y-m-d');
@endphp
    <h1>List Piutang</h1>
    <table style="font-weight: bold">
        <tr>
            <td width="15%">No. Invoice</td>
            <td>:</td>
            <td width="33%">{{ request()->invoice_no ?? '' }}</td>
            <td width="15%">Kode Customer</td>
            <td>:</td>
            <td width="33%">{{ request()->customer_code ?? '' }}</td>
        </tr>
        <tr>
            <td width="15%">Tgl. Invoice</td>
            <td>:</td>
            <td width="33%">{{ date('d/m/Y', strtotime($start_date)) }} - {{ date('d/m/Y', strtotime($end_date)) }}</td>
            <td width="15%">Nama Customer</td>
            <td>:</td>
            <td width="33%">{{ request()->customer_code_name ?? '' }}</td>
        </tr>
        <tr>
            <td width="15%">Status</td>
            <td>:</td>
            <td width="33%">{{ request()->status ?? '' }}</td>
            <td colspan="3"></td>
        </tr>
    </table>    
    <br>
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tgl. Invoice</th>
                <th>Nama Customer</th>
                <th>Jatuh Tempo</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Sisa Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $row)
            <tr>
                <td>{{ $row->invoice_no }}</td>
                <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                <td>{{ $row->customer_code }} &nbsp; {{ $row->customer_name }}</td>
                <td>{{ $row->expiry_date }}</td>
                <td>{{ number_format($row->total_price, 0) }}</td>
                <td>{{ number_format($row->total_paid_amount, 0) }}</td>
                <td>{{ number_format($row->piutang, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection