@extends('admin/print/template')
@section('content')
<?php 
$start_periode = date('d/m/Y', strtotime(request()->year.'-'.request()->month_start.'-01')); 
$end_periode = date('t/m/Y', strtotime(request()->year.'-'.request()->month_end.'-01'))
?>
    <center><h1>Rangkuman Laporan Laba Rugi</h1></center>
    <br>
    <b>Periode : {{ $start_periode }} - {{ $end_periode }}</b>
    <table class="table" style="width: 50%; margin-top: 30px">
        <tbody>
            <tr>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="table" style="width: 50%"> 
        <tbody>
            <tr>
                <td style="font-weight: bold">
                    Penjualan Kotor
                </td>
                <td>
                    : {{ number_format($penjualan_kotor, 0) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Modal Bersih
                </td>
                <td>
                    : {{ number_format($modal_bersih, 0) }}
                </td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    LABA KOTOR
                </td>
                <td>
                    : {{ number_format(($penjualan_kotor - $modal_bersih), 0) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Komisi Sales
                </td>
                <td>
                    : {{ number_format($komisi_sales, 0) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Beban Gaji
                </td>
                <td>
                    : {{ number_format($beban_ops, 0) }}
                </td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    TOTAL PENGELUARAN
                </td>
                <td>
                    : {{ number_format(($komisi_sales + $beban_ops), 0) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    TOTAL LABA BERSIH
                </td>
                <td>
                    : {{ number_format(($penjualan_kotor - $modal_bersih) - ($komisi_sales + $beban_ops), 0) }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection