@extends('admin.template')
@section('meta')
<title>Absen - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/absen') }}" class="btn btn-danger">
    <i class="fa-solid fa-calendar-days"></i> &nbsp; Absen
</a>
@endsection

@section('content')
@php
date_default_timezone_set('Asia/Jakarta');
@endphp
<form action="{{ url('admin/account/absen') }}" method="POST">
    <div class="row">
        <div class="col-6">
            @csrf
            <div class="row mb-2">
                <div class="col-4">
                    <span>Nama Sales</span>
                </div>
                <div class="col">
                    <select name="sales_code" required="required" class="form-select form-control">
                        <option value="" selected="selected" disabled="disabled">Pilih Sales...</option>
                        @foreach ($sales as $row)
                        <option value="{{ $row->sales_code }}">{{ $row->sales_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <span>Tanggal</span>
                </div>
                <div class="col">
                    <input type="date" required="required" value="{{ date('Y-m-d') }}" name="tanggal" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <span>Jam</span>
                </div>
                <div class="col">
                    <input type="time" required="required" name="jam" value="{{ date('H:i') }}" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <span>Absensi</span>
                </div>
                <div class="col">
                    <select name="type" class="form-control form-select">
                        <option value="in">Masuk</option>
                        <option value="out">Pulang</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col text-end">
            <button class="btn btn-danger btn-icon-lg" type="submit"><i class="fa-solid fa-save"></i> Simpan</button>
        </div>
    </div>
</form>
<div class="row mt-4 mb-2">
    <div class="col">
        <h2>List Absen</h2>
    </div>
</div>
<div class="row mb-2">
    <div class="col-8">
        <div class="row">
            <div class="col-3">
                Periode
            </div>
            <div class="col-4">
                <input type="date" name="start_date" value="{{ request()->get('start_date') }}" class="form-control">
            </div>
            <div class="col-1 text-center">
                s/d
            </div>
            <div class="col-4">
                <input type="date" name="end_date" value="{{ request()->get('end_date') }}" class="form-control">
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">    
        <table class="table table-striped print">
            <thead>
                <tr>
                    <th>Nama Sales</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Jenis Absensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $row)
                <tr>
                    <td>{{ $row->sales_name }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                    <td>{{ $row->jam }}</td>
                    <td>{{ ($row->type == 'in') ? 'Masuk' : 'Pulang' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <button class="btn btn-danger btn-icon-lg" id="printButton" type="submit"><i class="fa-solid fa-print"></i> Print</button>
    </div>
</div>
@endsection

@section('script')
<script>
    $('input[name=start_date]').on('change', function(){
        var params = {
            start_date : $('input[name=start_date]').val(),
            end_date : $('input[name=end_date]').val()
        }
        window.location.href = '{{ url()->current() }}?' + $.param(params);
    });
    $('input[name=end_date]').on('change', function(){
        var params = {
            start_date : $('input[name=start_date]').val(),
            end_date : $('input[name=end_date]').val()
        }
        window.location.href = '{{ url()->current() }}?' + $.param(params);
    });

    $('#printButton').on('click', function(){
        var params = {
            start_date : $('input[name=start_date]').val(),
            end_date : $('input[name=end_date]').val()
        }
        window.open('{{ url('admin/print/absen') }}?' + $.param(params), 'printWindow');
    });
</script>
@endsection