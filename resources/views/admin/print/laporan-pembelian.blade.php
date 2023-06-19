@extends('admin/print/template')
@section('content')
    <h1>Laporan Pembelian</h1>
    Periode 
    {{ ($_GET['date_start']) ? date('d M Y', strtotime($_GET['date_start'])) : '-' }} 
    s/d  
    {{ ($_GET['date_end']) ? date('d M Y', strtotime($_GET['date_end'])) : '-' }} 
    <br>
    <br>
    <table class="table table-striped print">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Tanggal Invoice</th>
                    <th>Jatuh Tempo</th>
                    <th>Nama Supplier</th>
                    <th>Status</th>
                    <th>Qty Barang</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($invoices as $row)
                <tr data-id="{{ $row->invoice_no }}">
                    <td>{{ $no }}</td>
                    <td>{{ $row->invoice_no }}</td>
                    <td>{{ $row->invoice_date }}</td>
                    <td>{{ $row->expiry_date }}</td>
                    <td>{{ $row->supplier_name }}</td>
                    <td>{{ $row->payment_type }}</td>
                    <td>{{ number_format($row->total_qty, 0) }}</td>
                    <td>{{ number_format($row->total_price, 0) }}</td>
                </tr>
                @php $no++; @endphp
                @endforeach
            </tbody>
    </table>
@endsection