@extends('admin/print/template')
@section('content')
    <h1>LAPORAN LABA RUGI <br> BULAN {{ $_GET['month'].'-'.$_GET['year'] }}</h1>
    <table class="table table-striped print">
        <tbody>
            <tr>
                <td>PENJUALAN KOTOR</td>
                <td>:</td>
                <td></td>
                <td class="text-end">{{ number_format($penjualan->amount, 0) }}</td>
            </tr>
            <tr>
                <td>MODAL BERSIH</td>
                <td>:</td>
                <td></td>
                <td class="text-end">{{ number_format($modal->modal, 0) }}</td>
            </tr>
            <?php $laba_kotor = $penjualan->amount - $modal->modal; ?>
            <tr>
                <td>LABA KOTOR</td>
                <td>:</td>
                <td></td>
                <td class="text-end">{{ number_format($laba_kotor, 0) }}</td>
            </tr>
            <?php 
            $total_komisi = 0;
            $total_pengeluaran = 0;
            foreach ($komisi as $kom) {
                $total_komisi +=  $kom['total_komisi'];
                $total_pengeluaran += $kom['total_komisi'];
            }
             ?>
            <tr>
                <td>KOMISI SALES</td>
                <td>:</td>
                <td class="text-end">{{ number_format($total_komisi, 0) }}</td>
                <td></td>
            </tr>
            <tr>
                <td>BIAYA JOURNAL</td>
                <td>:</td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $journal = [];
            foreach ($gaji as $gj) {
                if (!array_key_exists($gj->sales_code, $journal)) {
                    $journal[$gj->sales_code] = $gj->amount;
                } else {
                    $journal[$gj->sales_code] += $gj->amount;
                }
            }
            foreach ($beban as $bbn) {
                if (!array_key_exists($gj->sales_code, $journal)) {
                    $journal[$bbn->sales_code] = $bbn->amount;
                } else {
                    $journal[$bbn->sales_code] += $bbn->amount;
                }
            }
            foreach ($journal as $code => $amount) :
                $total_pengeluaran += $amount;
            ?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-end">{{ $code }} &nbsp;&nbsp;&nbsp; {{ number_format($amount, 0) }}</td>
                <td></td>
            </tr>
            <?php endforeach;?>

            <tr>
                <td>TOTAL PENGELUARAN</td>
                <td>:</td>
                <td></td>
                <td class="text-end">{{ number_format($total_pengeluaran, 0) }}</td>
            </tr>
            <tr>
                <td style="border-top: 2px solid black">KEUNTUNGAN</td>
                <td style="border-top: 2px solid black">:</td>
                <td style="border-top: 2px solid black"></td>
                <td class="text-end" style="border-top: 2px solid black">{{ number_format($laba_kotor - $total_pengeluaran, 0) }}</td>
            </tr>
        </tbody>
    </table>
@endsection