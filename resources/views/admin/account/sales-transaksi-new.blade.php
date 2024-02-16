@extends('admin.template')

@section('meta')
<title>Transaksi Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
</a>
<a href="{{ url('admin/account/sales/transaksi') }}" class="btn btn-danger">
    <i class="fa-solid fa-cash-register"></i> &nbsp; Transaksi
</a>
@endsection
@section('content')
<form action="{{ url('admin/account/sales/transaksi/new') }}" method="POST">
    @csrf
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-3 pt-2">
                Kode Sales
            </div>
            <div class="col-4">
                <select name="sales_code" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($sales as $row)
                    <option value="{{ $row->sales_code }}">{{ $row->sales_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
                <select name="sales_code_name" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($sales as $row)
                    <option value="{{ $row->sales_code }}">{{ $row->sales_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Tanggal
            </div>
            <div class="col-4">
                <input type="date" name="tx_date" value="{{ date('Y-m-d') }}" required="required" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Total
            </div>
            <div class="col-4">
                <input type="text" name="amount" data-type="number" required="required" class="form-control">
            </div>
        </div>
        {{-- <div class="row mt-2">
            <div class="col-3 pt-2">
                Jenis Pengeluaran
            </div>
            <div class="col-4">
                <select name="expense_type" class="form-select form-control">
                    <option value="beban_ops">Beban Operasional</option>
                    <option value="gaji">Gaji</option>
                </select>
            </div>
        </div> --}}
        <input type="hidden" name="expense_type" value="beban_ops">
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Keterangan
            </div>
            <div class="col-9">
                <textarea name="description" rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-save"></i>
            Save
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
</form>
@endsection