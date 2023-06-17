@extends('admin/print/template')
@section('content')
    <table>
        <tr>
            <td width="70%">
                TURBO EXPRESS MOTOR
                <br>JAKARTA
                <br><br>
                No. Faktur : {{ $invoice->invoice_no }}
            </td>
            <td>
                Jakarta, {{ date('d F Y') }}
                <br>
                Kepada Yth: {{ $invoice->supplier_name }}
            </td>
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
    </table>
    <br>
    <h2>Retur</h2>
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
            @foreach ($retur as $row)
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
    <br>

    <table>
        <tr>
            <td>
                Jatuh Tempo Tanggal {{ $invoice->expiry_date }}
            </td>
            <td class="text-end">
                Jumlah &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($invoice->total_price, 0) }}       
            </td>
        </tr>
    </table>
    <br>
    <table class="text-center">
        <tr>
            <td width="25%">Tanda Terima,</td>
            <td width="25%">Pengecek,</td>
            <td width="25%">Pengirim,</td>
            <td width="25%">Hormat kami,</td>
        </tr>
    </table>

@endsection