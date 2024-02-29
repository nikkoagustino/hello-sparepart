@extends('admin/print/template')
@section('content')
<?php 
$start_periode = date('d/m/Y', strtotime(request()->year.'-'.request()->month_start.'-01')); 
$end_periode = date('t/m/Y', strtotime(request()->year.'-'.request()->month_end.'-01'))
?>
    <center><h1>Laporan Laba Rugi</h1></center>
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
                <td></td>
                <td>
                    : {{ number_format($data['penjualan_kotor'], 0) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Modal Bersih
                </td>
                <td></td>
                <td>
                    : {{ number_format($data['modal_bersih'], 0) }}
                </td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    LABA KOTOR
                </td>
                <td></td>
                <td>
                    : {{ number_format(($data['penjualan_kotor'] - $data['modal_bersih']), 0) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Komisi Sales
                </td>
                <td></td>
                <td>
                    : {{ number_format($data['komisi_sales'], 0) }}
                </td>
            </tr>
            @foreach ($breakdown['komisi'] as $row)
            <tr>
                <td>{{ $row->sales_name }}</td>
                <td>: {{ number_format($row->komisi, 0) }}</td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">
                    Beban Gaji
                </td>
                <td></td>
                <td>
                    : {{ number_format($data['gaji'], 0) }}
                </td>
            </tr>
            @foreach ($breakdown['gaji'] as $row)
            <tr>
                <td>{{ $row->sales_name }}</td>
                <td>: {{ number_format($row->gaji, 0) }}</td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">
                    Beban Operasional
                </td>
                <td></td>
                <td>
                    : {{ number_format($data['beban_ops'], 0) }}
                </td>
            </tr>
            <tr>
                <td>Inventaris</td>
                <td>: {{ number_format($breakdown['beban_ops']['inventaris'], 0) }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Reimburse</td>
                <td>: {{ number_format($breakdown['beban_ops']['reimburse'], 0) }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Pulsa Karyawan</td>
                <td>: {{ number_format($breakdown['beban_ops']['pulsa'], 0) }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Lainnya</td>
                <td>: {{ number_format($breakdown['beban_ops']['other'], 0) }}</td>
                <td></td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    TOTAL PENGELUARAN
                </td>
                <td></td>
                <td>
                    : {{ number_format(($data['komisi_sales'] + $data['gaji'] + $data['beban_ops']), 0) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr style="font-weight: bold">
                <td>
                    TOTAL LABA BERSIH
                </td>
                <td></td>
                <td>
                    : {{ number_format(($data['penjualan_kotor'] - $data['modal_bersih']) - ($data['komisi_sales'] + $data['gaji'] + $data['beban_ops']), 0) }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection