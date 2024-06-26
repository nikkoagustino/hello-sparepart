@extends('admin.template')

@section('meta')
<title>{{ $invoice->invoice_no }} - Pembayaran Invoice - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-dashboard.svg') }}"> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/piutang') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/piutang.svg') }}"> &nbsp; Piutang
</a>
<a href="{{ url()->current() }}" class="btn btn-danger">
    <i class="fa-solid fa-coins"></i> &nbsp; Bayar
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-6">
                <input type="text" name="invoice_no" readonly="readonly" value="{{ $invoice->invoice_no }}" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-3">
                <input type="date" readonly="readonly" name="invoice_date" value="{{ $invoice->invoice_date }}" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Customer
            </div>
            <div class="col-3">
                <input name="customer_code" value="{{ $invoice->customer_code }}" readonly="readonly" class="form-control">
            </div>
            <div class="col-6">
                <input name="customer_code_name" value="{{ $invoice->customer_name }}" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Sales
            </div>
            <div class="col-3">
                <input name="sales_code" value="{{ $invoice->sales_code }}" readonly="readonly" class="form-control">
            </div>
            <div class="col-6">
                <input name="sales_code_name" value="{{ $invoice->sales_name }}" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="payButton" class="btn btn-danger btn-icon-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
            <i class="fa-solid fa-circle-plus"></i>
            New
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <th>Bukti Pembayaran</th>
                    <th>Total Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @php $total_paid_amount = 0; @endphp
                @foreach($payments as $row)
                <tr>
                    <td>{{ $row->payment_date }}</td>
                    <td>
                        @if ($row->payment_proof)
                        <a href="{{ Storage::url($row->payment_proof) }}" target="_blank">
                            <i class="fa-solid fa-eye"></i> Tampilkan
                        </a>
                        @else
                        Tidak upload bukti pembayaran
                        @endif
                    </td>
                    <td>{{ number_format($row->paid_amount, 0) }}</td>
                </tr>
                @php $total_paid_amount += $row->paid_amount; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-2">
        <div class="col"></div>
        <div class="col-4">
            <div class="row">
                <div class="col-5">
                    Total Invoice
                </div>
                <div class="col">
                    <input type="text" class="form-control bg-khaki" readonly="readonly" value="{{ number_format($invoice->total_price, 0) }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-5">
                    Sisa
                </div>
                <div class="col">
                    <input type="text" class="form-control" readonly="readonly" value="{{ number_format($invoice->total_price - $total_paid_amount, 0) }}">
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal modal-lg fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('admin/dashboard/piutang/bayar') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <div class="row mb-1">
                            <div class="col-3">
                                No. Invoice
                            </div>
                            <div class="col-9">
                                <input type="text" value="{{ $invoice->invoice_no }}" name="invoice_no" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                Tanggal Invoice
                            </div>
                            <div class="col-9">
                                <input type="date" name="invoice_date" value="{{ $invoice->invoice_date }}" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                Kode Customer
                            </div>
                            <div class="col-2">
                                <input type="text" name="customer_code" value="{{ $invoice->customer_code }}" readonly="readonly" class="form-control">
                            </div>
                            <div class="col-7">
                                <input type="text" name="customer_name" value="{{ $invoice->customer_name }}" readonly="readonly" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="col text-end">
                        <button type="submit" id="savePayment" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button type="cancel" data-bs-dismiss="modal" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-8">
                        <div class="row mb-1">
                            <div class="col-3">
                                Tanggal Bayar
                            </div>
                            <div class="col-9">
                                <input type="date" name="payment_date" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                Total Bayar
                            </div>
                            <div class="col-9">
                                <input type="text" data-type="number" required="required" name="paid_amount" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                Sisa Hutang
                            </div>
                            <div class="col-9">
                                <input type="text" data-type="number" value="{{ number_format($invoice->total_price - $total_paid_amount, 0) }}" readonly="readonly" name="payment_left" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                Bukti Bayar
                            </div>
                            <div class="col-9">
                                <input type="file" accept="image/*" name="payment_proof_file" class="form-control">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection