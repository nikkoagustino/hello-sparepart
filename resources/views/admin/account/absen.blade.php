@extends('admin.template')
@section('meta')
<title>Absen - {{ env('APP_NAME') }}</title>
@endsection
@section('content')
@php
date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="row">
    <div class="col-4">
        <form action="{{ url('admin/account/absen') }}" method="POST">
            @csrf
            <h2>Tambah Absen</h2>
            <span>Nama Sales</span>
            <select name="sales_code" required="required" class="form-select form-control">
                <option value="" selected="selected" disabled="disabled">Pilih Sales...</option>
                @foreach ($sales as $row)
                <option value="{{ $row->sales_code }}">{{ $row->sales_code }} - {{ $row->sales_name }}</option>
                @endforeach
            </select>
            <span>Tanggal</span>
            <input type="date" required="required" value="{{ date('Y-m-d') }}" name="tanggal" class="form-control mb-2">
            <span>Jam</span>
            <input type="time" required="required" name="jam" value="{{ date('H:i') }}" class="form-control mb-2">
            <span>Jenis Absen</span>
            <br>
            <input type="radio" name="type" value="in" required="required" class="form-check-input"> Masuk
            <br>
            <input type="radio" name="type" value="out" required="required" class="form-check-input"> Pulang
            <br>
            <button class="btn btn-success mt-2"><i class="fa-solid fa-save"></i> Simpan</button>
        </form>
    </div>

    <div class="col">
        <h2>List Absen</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Sales</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Jenis</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $row)
                <tr>
                    <td>{{ $row->sales_code }} - {{ $row->sales_name }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->jam }}</td>
                    <td>
                        @if ($row->type == 'in')
                        <span class="badge bg-success">Masuk</span>
                        @else
                        <span class="badge bg-danger">Pulang</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection