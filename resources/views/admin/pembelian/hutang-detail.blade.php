@extends('admin.template')

@section('meta')
<title>Hutang - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')

<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/hutang') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/hutang.svg') }}"> &nbsp; Hutang
</a> 
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-7">
                <input type="text" value="{{ $invoice->invoice_no }}" readonly="readonly" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-3">
                <input type="date" readonly="readonly" value="{{ $invoice->invoice_date }}" name="invoice_date" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Kode Supplier
            </div>
            <div class="col-3">
                <input name="supplier_code" class="form-control" readonly="readonly" value="{{ $invoice->supplier_code }}">
            </div>
            <div class="col-6">
                <input name="supplier_code_name" class="form-control" readonly="readonly" value="{{ $invoice->supplier_name }}">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Alamat
            </div>
            <div class="col-9">
                <textarea name="address" rows="3" readonly="readonly" class="form-control">{{ $invoice->supplier_address }}</textarea>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Jatuh Tempo
            </div>
            <div class="col-3">
                <input name="days_expire" readonly="readonly" type="date" value="{{ $invoice->expiry_date }}" class="form-control">
            </div>
            <div class="col-1">
                Ket
            </div>
            <div class="col-5">
                <input name="description" readonly="readonly" value="{{ $invoice->description }}" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Status
            </div>
            <div class="col-3">
                <input name="status" value="{{ $invoice->invoice_status ?? 'HUTANG' }}" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        {{-- <a href="{{ url('admin/pembelian/invoice/list') }}" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-receipt"></i>
            List
        </a> --}}
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed" id="itemsTable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga /pcs</th>
                    <th>Disc (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $row)
                <tr>
                    <td>{{ $row->product_code }}</td>
                    <td>{{ $row->type_code }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ $row->normal_price }}</td>
                    <td>{{ $row->discount_rate }}</td>
                    <td>{{ $row->subtotal_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-2 mb-5">
    <div class="col">
        <button id="bayarButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-coins"></i>
            Bayar
        </button>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <b>Total Invoice</b>
            </div>
            <div class="col">
                <input type="text" data-type="number" readonly="readonly" class="form-control bg-khaki" value="{{ $invoice->total_invoice_price }}" name="total_invoice_price">
            </div>
        </div>
        @php
        $total_bayar = 0;
        foreach ($payments as $payment) {
            $total_bayar += $payment->paid_amount;
        }
        @endphp
        <div class="row mt-2">
            <div class="col">
                <b>Pembayaran</b>
            </div>
            <div class="col">
                <input type="text" data-type="number" readonly="readonly" class="form-control" value="{{ $total_bayar }}" name="total_bayar">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <b>Sisa</b>
            </div>
            <div class="col">
                <input type="text" data-type="number" readonly="readonly" class="form-control bg-khaki" value="{{ $invoice->total_invoice_price - $total_bayar }}" name="sisa">
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $('input').trigger('change');
    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        window.open('{{ url('admin/print/hutang-detail') }}?invoice_no='+invoice_no, 'printWindow');
    });
    $('#bayarButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        window.location.href = '{{ url('admin/pembelian/hutang/bayar') }}?invoice_no='+invoice_no;
    });
</script>
@endsection