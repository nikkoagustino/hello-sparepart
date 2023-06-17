@extends('admin/print/template')
@section('content')
    <h1>LAPORAN AKHIR LABA TAHUN {{ $year }}</h1>
    <table class="table table-striped print">
        <thead>
            <tr>
                <th>BULAN</th>
                <th>LABA KOTOR</th>
                <th>PENGELUARAN</th>
                <th>LABA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $row)
            <?php 
            $dt = DateTime::createFromFormat('!m', $row->month);
            setlocale(LC_TIME, 'id');
            $monthName = strftime('%B', $dt->getTimestamp());
            ?>
            <tr>
                <td>{{ strtoupper($monthName) }}</td>
                <td>{{ number_format($row->laba_kotor, 0) }}</td>
                <td>{{ number_format($row->total_pengeluaran, 0) }}</td>
                <td>{{ number_format($row->laba_bersih, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection