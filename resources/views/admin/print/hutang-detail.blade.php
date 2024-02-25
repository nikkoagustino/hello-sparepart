@extends('admin/print/template')
@section('content')
    <h1>HUTANG</h1>
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
        <tr>
            <td width="15%"><b>Status</b></td>
            <td width="35%">: {{ ($hutang->hutang <= 0) ? 'LUNAS' : 'HUTANG' }}</td>
            <td width="15%"></td>
            <td width="35%"></td>
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
                <td class="text-end">TOTAL</td>
                <td>
                    {{ number_format($invoice->total_price, 0) }}
                </td>
            </tr>
            <?php $total_paid = 0; $x = 0; ?>
            @foreach ($payments as $payment)
            <?php $total_paid += (int) $payment->paid_amount; $x++; ?>
            <tr>
                <td colspan="5">
                </td>
                <td class="text-end">PEMBAYARAN {{ $x }}</td>
                <td>
                    {{ number_format($payment->paid_amount, 0) }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">
                </td>
                <td class="text-end">SISA</td>
                <td>
                    {{ number_format(($hutang->hutang), 0) }}
                </td>
            </tr>
        </tfoot>
    </table>
@endsection