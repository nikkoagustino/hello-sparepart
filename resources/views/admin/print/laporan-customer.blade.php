@extends('admin/print/template')
@section('content')
<?php 
$start_periode = date('d/m/Y', strtotime(request()->date_start)); 
$end_periode = date('d/m/Y', strtotime(request()->date_end));
?>
    <h1>Laporan Penjualan per Customer</h1>
    <table>
        <tr>
            <td width="15%"><b>Periode</b></td>
            <td width="35%">
                : {{ $start_periode }} - {{ $end_periode }}
            </td>
            <td width="50%"></td>
        </tr>
        <tr>
            <td><b>Nama Customer</b></td>
            <td>
                : {{ $customer->customer_code }} - {{ $customer->customer_name }}
            </td>
            <td></td>
        </tr>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga / pc</th>
                <th>Disc (%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            @foreach ($data as $row)
            <?php $total += (int) $row->subtotal_price; ?>
            <tr>
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->normal_price, 0) }}</td>
                <td>{{ number_format($row->discount_rate, 2) }}</td>
                <td>{{ number_format($row->subtotal_price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td>TOTAL</td>
                <td>{{ number_format($total, 0) }}</td>
            </tr>
        </tfoot>
    </table>
@endsection