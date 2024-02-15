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
<form action="{{ url('admin/account/sales/transaksi/edit') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $tx_data->id }}">
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-3 pt-2">
                Kode Sales
            </div>
            <div class="col-4">
                <input type="text" name="sales_code" value="{{ $tx_data->sales_code }}" class="form-control" readonly="readonly">
            </div>
            <div class="col-5">
                <input type="text" name="sales_name" value="{{ $tx_data->sales_name }}" class="form-control" readonly="readonly">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Tanggal
            </div>
            <div class="col-4">
                <input type="date" readonly="readonly" name="tx_date" value="{{ $tx_data->tx_date }}" required="required" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Total
            </div>
            <div class="col-4">
                <input type="text" readonly="readonly" name="amount" value="{{ number_format($tx_data->amount, 0) }}" data-type="number" required="required" class="form-control">
            </div>
        </div>
        <input type="hidden" name="expense_type" value="beban_ops">
        {{-- <div class="row mt-2">
            <div class="col-3 pt-2">
                Jenis Pengeluaran
            </div>
            <div class="col-4">
                <select name="expense_type" class="form-select form-control">
                    <option value="beban_ops" {{ ($tx_data->expense_type == 'beban_ops') ? 'selected="selected"' : ''  }}>Beban Operasional</option>
                    <option value="gaji" {{ ($tx_data->expense_type == 'gaji') ? 'selected="selected"' : ''  }}>Gaji</option>
                </select>
            </div>
        </div> --}}
        <div class="row mt-2">
            <div class="col-3 pt-2">
                Keterangan
            </div>
            <div class="col-9">
                <textarea name="description" readonly="readonly" rows="7" class="form-control">{{ $tx_data->description }}</textarea>
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-save"></i>
            Save
        </button>
        <button id="editButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
</form>
@endsection

@section('script')
<script>
    function enableEdit() {
        $('#deleteButton').hide();
        $('input[name=tx_date]').removeAttr('readonly');
        $('input[name=amount]').removeAttr('readonly');
        $('textarea[name=description]').removeAttr('readonly');
    }
</script>
@endsection