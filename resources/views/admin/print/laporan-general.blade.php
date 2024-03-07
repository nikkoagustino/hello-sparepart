@extends('admin/print/template')
@section('content')
    <h1>Laporan General</h1>
    <table>
        <tr>
            <td width="15%"><b>Periode</b></td>
            <td width="35%">
                : {{ request()->month }}/{{ request()->year }}
            </td>
            <td width="50%"></td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <td width="30%">
                <b><u>TOTAL KEUNTUNGAN</u></b>
            </td>
            <td width="50%">
                <b>: <u>Rp {{ number_format($monthly['monthly']['profit'], 0) }}</u></b>
            </td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td>
                <b><u>TOTAL PEMASUKAN</u></b>
            </td>
            <td>
                <b>: <u>Rp {{ number_format($monthly['monthly']['income'], 0) }}</u></b>
            </td>
        </tr>
        <tr>
            <td>
                <b><u>TOTAL PENGELUARAN</u></b>
            </td>
            <td>
                <b>: <u>Rp {{ number_format($monthly['monthly']['expense'], 0) }}</u></b>
            </td>
        </tr>
    </table>
    <table style="margin-top: 50px">
        <tr>
            <td colspan="3"><b>LAPORAN PENJUALAN PER PERIODE</b></td>
        </tr>
        @foreach ($chart['expenses'] as $index => $value)
        <tr>
            <td colspan="3">
                <b><i>
                    {{ $chart['expenses'][$index]['month_name'] }}
                </i></b>
            </td>
        </tr>
        <tr>
            <td width="30%">
                PENGELUARAN
            </td>
            <td width="50%">
                : Rp {{ number_format($chart['expenses'][$index]['amount'], 0) }}
            </td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="30%">
                KEUNTUNGAN
            </td>
            <td width="50%">
                : Rp {{ number_format($chart['profit'][$index]['amount'], 0) }}
            </td>
            <td width="30%"></td>
        </tr>
        @endforeach
    </table>
    <div style="position: relative; display: block; margin-top: 50px">
        <div style="float: left; border-right: 2px solid black; height: 300px; width: 40%;">
            <b>LAPORAN TOP 10 BEST SELLER</b>
            <ol>
                @foreach ($best_seller as $row)
                <li style="position: relative;">
                    {{ $row->product_code }}
                    <span style="position: absolute; right: 20px">{{ $row->total_qty }}</span>
                </li>
                @endforeach
            </ol>
        </div>
        <div style="float: right; width: 59%;">
            <b>LAPORAN TOP 10 BEST SELLER</b>
            <ol>
                @foreach ($best_customer as $row)
                <li style="position: relative;">
                    {{ $row->customer_name }}
                    <span style="position: absolute; right: 20px">{{ number_format($row->total_price, 0) }}</span>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection