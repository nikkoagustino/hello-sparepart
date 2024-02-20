@extends('admin/print/template')
@section('content')
<table>
    <tr>
        <td width="50%" colspan="2">
            <img src="{{ url('assets/img/logo-bw.png') }}" style="height: 80px" alt="">
        </td>
        <td width="50%" rowspan="4">
            <b>Kepada Yth</b>
            <div style="border: 1px solid black; padding: 10px 20px; width: 90%">
            {{ $master->customer_name }}<br>
            {{ $master->customer_address }}
            </div>
        </td>
    </tr>
    <tr>
        <td width="10%"><b>No. Invoice</b></td>
        <td width="40%">: {{ $master->invoice_no }}</td>
    </tr>
    <tr>
        <td><b>Tgl. Invoice</b></td>
        <td>: {{ $master->invoice_date }}</td>
    </tr>
    <tr>
        <td><b>Sales</b></td>
        <td>: {{ $master->sales_name }}</td>
    </tr>
</table>
<br>
<table class="table">
    <thead>
        <tr>
            <th width="20%">Kode Barang</th>
            <th width="10%">Jenis Barang</th>
            <th width="40%">Nama Barang</th>
            <th width="5%">Qty</th>
            <th width="10%">Harga</th>
            <th width="5%">Disc</th>
            <th width="10%">Total</th>
        </tr>
    </thead>
    <tbody>
        @php $total_price = 0; @endphp
        @foreach($items as $row)
        <tr>
            <td>{{ $row->product_code }}</td>
            <td>{{ $row->type_code }}</td>
            <td>{{ $row->product_name }}</td>
            <td>{{ $row->qty }}</td>
            <td>{{ number_format($row->normal_price, 0) }}</td>
            <td>{{ number_format($row->discount_rate, 2) }}%</td>
            <td>{{ number_format($row->subtotal_price, 0) }}</td>
            <td></td>
        </tr>
        @php $total_price += $row->subtotal_price; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Jatuh Tempo : {{ date('d F Y', strtotime($master->expiry_date)) }}</td>
            <td colspan="2"><center>TOTAL</center></td>
            <td>{{ number_format($total_price, 0) }}</td>
        </tr>
    </tfoot>
</table>
<br>
<table>
    <tr>
        <td><center>Tanda Terima,</center></td>
        <td><center>Pengirim,</center></td>
        <td><center>Hormat Kami,</center></td>
    </tr>
</table>
@endsection