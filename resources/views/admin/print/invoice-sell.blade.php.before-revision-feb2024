@extends('admin/print/template')
@section('content')
    <table>
        <tr>
            <td width="50%">
                <img src="{{ url('assets/img/logo-bw.png') }}" alt="">
            </td>
            <td>
                <h1>INVOICE</h1>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width: 200px; display: inline-block">No. Invoice</div>: {{ $invoice->invoice_no }}<br>
                <div style="width: 200px; display: inline-block">Tanggal</div>: {{ date('d F Y', strtotime($invoice->invoice_date)) }}<br>
                <div style="width: 200px; display: inline-block">Sales</div>: {{ $invoice->sales_name }}
            </td>
            <td style="vertical-align: top">
                <div style="width: 200px; display: inline-block">Kepada Yth.</div>: {{ $invoice->customer_name }}<br>
                <div style="width: 200px; display: inline-block">No. Telp</div>: {{ $invoice->customer_phone_1 ?? '' }} {{ ($invoice->customer_phone_2) ? '/ '.$invoice->customer_phone_2 : '' }}<br>
            </td>
        </tr>
    </table>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                {{-- <th>Jenis Barang</th> --}}
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Disc (%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($items as $row)
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $no }}</td>
                <td>{{ $row->product_code }}</td>
                {{-- <td>{{ $row->type_code }}</td> --}}
                <td>{{ $row->product_name }}</td>
                <td style="text-align: right">{{ number_format($row->qty, 0) }}</td>
                <td style="text-align: right">{{ number_format($row->normal_price, 0) }}</td>
                <td style="text-align: right">{{ number_format($row->discount_rate, 2) }}</td>
                <td style="text-align: right">{{ number_format($row->qty * (int) ($row->normal_price - ($row->normal_price * ($row->discount_rate / 100))), 0) }}</td>
            </tr>
            <?php $no++; ?>
            @endforeach
        </tbody>
    </table>
    <br>
    @if (count($retur) > 0)
    <h2>Retur</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                {{-- <th>Jenis Barang</th> --}}
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga /pcs</th>
                <th>Disc (%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($retur as $row)
            <tr data-id="{{ $row->product_code }}">
                <td>{{ $no }}</td>
                <td>{{ $row->product_code }}</td>
                {{-- <td>{{ $row->type_code }}</td> --}}
                <td>{{ $row->product_name }}</td>
                <td style="text-align: right">{{ number_format($row->qty, 0) }}</td>
                <td style="text-align: right">{{ number_format($row->normal_price, 0) }}</td>
                <td style="text-align: right">{{ number_format($row->discount_rate, 2) }}</td>
                <td style="text-align: right">{{ number_format($row->qty * (int) ($row->normal_price - ($row->normal_price * ($row->discount_rate / 100))), 0) }}</td>
            </tr>
            <?php $no++; ?>
            @endforeach
        </tbody>
    </table>
    @endif
    <br>

    <table class="summary">
        <tr>
            <td style="
                width: 50%; 
                border-top: 2px solid black;
            ">
                <div style="width: 300px; display: inline-block;">Status Pembayaran</div>: {{ $invoice->payment_type }}<br>
                <div style="width: 300px; display: inline-block;">Tgl. Jatuh Tempo</div>: {{ $invoice->expiry_date }}
            </td>
            <td style="
                border-top: 2px solid black;
                border-bottom: 2px solid black;
                border-left: 2px solid black;
            ">
                <div style="width: 48%; display: inline-block;">TOTAL</div>
                <div style="width: 50%; text-align: right; display: inline-block;">
                    {{ number_format($invoice->total_price, 0) }}       
                </div>
            </td>
        </tr>
        <tr>
            <td style="
                vertical-align: top;
                padding-top: 50px;
                border-bottom: 2px solid black;
            ">
                <div style="width: 48%; display: inline-block;">Hormat Kami,</div>
                <div style="width: 48%; display: inline-block;">Pengirim,</div>
            </td>
            <td style="
                padding-top: 50px;
                border-left: 2px solid black;
                border-bottom: 2px solid black;
                height: 300px;
                text-align: center;
                vertical-align: top;
            ">
                Tanda Terima,
            </td>
        </tr>
    </table>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            border-collapse: collapse;
        }
        th {
            padding: 7px;
            border-left: 2px solid black;
        }
        td {
            padding: 7px;
        }
        th:nth-child(1) {
            border-left: none;
        }
    </style>
@endsection