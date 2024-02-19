@extends('admin/print/template')
@section('content')
<table>
    <tr>
        <td>
            <img src="{{ url('assets/img/logo-bw.png') }}" style="height: 80px" alt="">
        </td>
        <td style="text-align: right; font-weight: 900; font-size: 3rem;">
            <b>SURAT JALAN</b>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td width="10%"><b>No. Invoice</b></td>
        <td width="40%">: {{ $master->invoice_no }}</td>
        <td width="10%"><b>Kepada Yth</b></td>
        <td width="40%" rowspan="3" style="border: 1px solid black; padding: 0 10px">
            {{ $master->customer_name }}<br>
            {{ $master->customer_address }}
        </td>
    </tr>
    <tr>
        <td><b>Tgl. Invoice</b></td>
        <td>: {{ $master->invoice_date }}</td>
    </tr>
    <tr>
        <td><b>Sales</b></td>
        <td>: {{ $master->sales_name }}</td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td><b>Tgl. Kirim</b></td>
        <td>: {{ date('d/m/Y', strtotime(request()->tgl_kirim)) }}</td>
    </tr>
</table>
Kami kirimkan barang di bawah ini:
<table class="table">
    <thead>
        <tr>
            <th width="20%">Kode Barang</th>
            <th width="10%">Jenis Barang</th>
            <th width="40%">Nama Barang</th>
            <th width="5%">Qty</th>
            <th width="25%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $row)
        <tr>
            <td>{{ $row->product_code }}</td>
            <td>{{ $row->type_code }}</td>
            <td>{{ $row->product_name }}</td>
            <td>{{ $row->qty }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
Mohon untuk dapat diterima dengan baik dan cukup.
<br><br>
<table>
    <tr>
        <td><center>Tanda Terima,</center></td>
        <td><center>Pengirim,</center></td>
        <td><center>Hormat Kami,</center></td>
    </tr>
</table>
@endsection