@extends('admin/print/template')
@section('content')
@php
$start_date = request()->start_date ?? config('user.MIN_YEAR').'-01-01';
$end_date = request()->end_date ?? date('Y/m/d');
@endphp
    <center><h1><u>ABSEN SALES</u></h1></center>
    <br>
    <b>Periode : {{ date('d/m/Y', strtotime($start_date)) }} - {{ date('d/m/Y', strtotime($end_date)) }}</b>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Sales</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jenis Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->sales_name }}</td>
                <td>{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                <td>{{ $row->jam }}</td>
                <td>{{ ($row->type == 'in') ? 'Masuk' : 'Pulang' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection