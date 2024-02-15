@extends('admin/print/template')
@section('content')
<?php $periode = request()->year.'-'.request()->month.'-01'; ?>
    <center><h1><u>TRANSAKSI PER SALES</u></h1></center>
    <br>
    <b>Periode : {{ date('01/m/Y', strtotime($periode)) }} - {{ date('t/m/Y', strtotime($periode)) }}</b>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Sales</th>
                <th>Nama Sales</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($txs as $row)
            <tr>
                <td>{{ $row->sales_code }}</td>
                <td>{{ $row->sales_name }}</td>
                <td>{{ date('d/m/Y', strtotime($row->tx_date)) }}</td>
                <td>{{ number_format($row->amount, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection