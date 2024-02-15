@extends('admin/print/template')
@section('content')
<?php $periode = request()->year.'-'.request()->month.'-01'; ?>
    <center><h1><u>KOMISI SALES</u></h1></center>
    <br>
    <b>Periode : {{ date('01/m/Y', strtotime($periode)) }} - {{ date('t/m/Y', strtotime($periode)) }}</b>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tgl. Invoice</th>
                <th>Tgl. Bayar</th>
                <th>Nama Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $row)
            <tr>
                <td>{{ $row->invoice_no }}</td>
                <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                <td>{{ date('d/m/Y', strtotime($row->payment_date)) }}</td>
                <td>{{ $row->customer_name }}</td>
                <td>{{ number_format($row->paid_amount, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection