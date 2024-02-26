@extends('admin/print/template')
@section('content')
@if (Str::contains(request()->url(), 'retur'))
    <h1>INVOICE RETUR PEMBELIAN</h1>
@else
    <h1>INVOICE PEMBELIAN</h1>
@endif
    <table>
        <tr>
            <td width="15%"><b>No. Invoice</b></td>
            <td width="35%">: {{ $invoice->invoice_no }}</td>
            <td width="15%"><b>Kode Supplier</b></td>
            <td width="35%">: {{ $invoice->supplier_code }}</td>
        </tr>
        <tr>
            <td width="15%"><b>Tgl. Invoice</b></td>
            <td width="35%">: {{ date('d F Y', strtotime($invoice->invoice_date)) }}</td>
            <td width="15%"><b>Nama Supplier</b></td>
            <td width="35%">: {{ $invoice->supplier_name }}</td>
        </tr>
    </table>
    <br>
    <table class="table">
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
        <tfoot>
            <tr>
                <td colspan="5">
                    Jatuh Tempo : {{ date('d F Y', strtotime($invoice->expiry_date)) }}
                </td>
                <td>TOTAL</td>
                <td>
                    {{ number_format($invoice->total_price, 0) }}
                </td>
            </tr>
        </tfoot>
    </table>
    <br>
    @if (count($retur) > 0)
    <h2>RETUR</h2>
    <table class="table">
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
            <?php
            $total_retur_price = 0;
            foreach ($retur as $row):
                $subtotal_retur = $row->qty * (int) ($row->normal_price - ($row->normal_price * ($row->discount_rate / 100)));
                $total_retur_price += $subtotal_retur;
            ?>
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $row->product_code }}</td>
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ number_format($row->qty, 0) }}</td>
                <td>{{ number_format($row->normal_price, 0) }}</td>
                <td>{{ number_format($row->discount_rate, 2) }}</td>
                <td>{{ number_format($subtotal_retur, 0) }}</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                </td>
                <td>TOTAL</td>
                <td>
                    {{ number_format($invoice->total_retur_price, 0) }}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif
    <br>
@endsection