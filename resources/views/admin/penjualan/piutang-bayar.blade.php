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
        {{-- <div class="row mt-1">
            <div class="col-3">
                Kode Sales
            </div>
            <div class="col-3">
                <input name="sales_code" value="{{ $invoice->sales_code }}" readonly="readonly" class="form-control">
            </div>
            <div class="col-6">
                <input name="sales_code_name" value="{{ $invoice->sales_name }}" readonly="readonly" class="form-control">
            </div>
        </div> --}}
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
                <tr data-id="{{ $row->id }}">
                    <td class="payment_date">{{ $row->payment_date }}</td>
                    <td>
                        @if ($row->payment_proof)
                        <a href="{{ Storage::url($row->payment_proof) }}" target="_blank">
                            <i class="fa-solid fa-eye"></i> Tampilkan
                        </a>
                        @else
                        Tidak upload bukti pembayaran
                        @endif
                    </td>
                    <td class="paid_amount">{{ number_format($row->paid_amount, 0) }}</td>
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
            <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-7">
                        <div class="breadcrumb">
                            <div class="row">
                                <div class="col">
                                    <a href="javascript:void(0)" class="btn btn-danger">
                                        <i class="fa-solid fa-pencil"></i> &nbsp; Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                No. Invoice
                            </div>
                            <div class="col-6">
                                <input type="text" value="{{ $invoice->invoice_no }}" name="invoice_no" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Tanggal Invoice
                            </div>
                            <div class="col-6">
                                <input type="date" name="invoice_date" value="{{ $invoice->invoice_date }}" readonly="readonly" class="form-control">
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
                    <div class="col-7">
                        <div class="row mb-1">
                            <div class="col-4">
                                Tanggal Bayar
                            </div>
                            <div class="col-8">
                                <input type="date" name="payment_date" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Total Bayar
                            </div>
                            <div class="col-8">
                                <input type="text" data-type="number" required="required" name="paid_amount" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Sisa Piutang
                            </div>
                            <div class="col-8">
                                <input type="text" data-type="number" value="{{ number_format($invoice->total_price - $total_paid_amount, 0) }}" readonly="readonly" name="payment_left" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Bukti Bayar
                            </div>
                            <div class="col-8">
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

<div class="modal modal-lg fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('admin/penjualan/piutang/edit-bayar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_id">
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-7">
                        <div class="breadcrumb">
                            <div class="row">
                                <div class="col">
                                    <a href="javascript:void(0)" class="btn btn-danger">
                                        <i class="fa-solid fa-pencil"></i> &nbsp; Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                No. Invoice
                            </div>
                            <div class="col-6">
                                <input type="text" value="{{ $invoice->invoice_no }}" name="invoice_no" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Tanggal Invoice
                            </div>
                            <div class="col-6">
                                <input type="date" name="invoice_date" value="{{ $invoice->invoice_date }}" readonly="readonly" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="col text-end">
                        <button type="submit" id="savePayment" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button id="deletePayment" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                        <button type="cancel" data-bs-dismiss="modal" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-4">
                                Kode Customer
                            </div>
                            <div class="col-3">
                                <input type="text" name="customer_code" value="{{ $invoice->customer_code }}" readonly="readonly" class="form-control">
                            </div>
                            <div class="col-5">
                                <input type="text" name="customer_name" value="{{ $invoice->customer_name }}" readonly="readonly" class="form-control" style="width: 200%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-7">
                        <div class="row mb-1">
                            <div class="col-4">
                                Tanggal Bayar
                            </div>
                            <div class="col-8">
                                <input type="date" name="edit_payment_date" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Total Bayar
                            </div>
                            <div class="col-8">
                                <input type="text" data-type="number" required="required" name="edit_paid_amount" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Sisa Hutang
                            </div>
                            <div class="col-8">
                                <input type="text" data-type="number" value="{{ number_format($invoice->total_price - $total_paid_amount, 0) }}" readonly="readonly" name="payment_left" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">
                                Bukti Bayar
                            </div>
                            <div class="col-8">
                                <input type="file" accept="image/*" name="edit_payment_proof_file" class="form-control">
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
@section('script')
<script>
    var selected_row;
    $('#deletePayment').on('click', function(){
        event.preventDefault();
        $('#editPaymentModal').modal('hide');
        $('#deleteModal').modal('show');
    });
    function enableDelete()
    {
        window.location.href = '{{ url('admin/penjualan/piutang/delete-bayar') }}?id='+selected_row;
    }

    $('.selectable').on('click', 'tbody tr', function() {
        selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');

        if (selected_row) {
            // open edit bayar modal
            $('input[name=edit_id]').val(selected_row);
            $('input[name=edit_payment_date]').val($(this).find('.payment_date').text());
            $('input[name=edit_paid_amount]').val($(this).find('.paid_amount').text()).change();
            $('#editPaymentModal').modal('show');
        } else {
            alert('Pilih Data Terlebih Dahulu');
        }
    });
</script>
@endsection