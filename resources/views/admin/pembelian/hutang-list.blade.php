@extends('admin.template')

@section('meta')
<title>List Hutang - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-dashboard.svg') }}"> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/hutang') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/hutang.svg') }}"> &nbsp; Hutang
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-2">
                No Invoice
            </div>
            <div class="col-7">
                <input name="invoice_no" placeholder="INVxxx" type="text" autocomplete="off" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-2">
                Periode
            </div>
            <div class="col-3">
                <input type="date" value="{{ $_GET['date_start'] ?? '' }}" name="date_start" class="form-control">
            </div>
            <div class="col-1">
                s/d
            </div>
            <div class="col-3">
                <input type="date" value="{{ $_GET['date_end'] ?? '' }}" name="date_end" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-2">
                Kode Supplier
            </div>
            <div class="col-3">
                <select name="supplier_code" class="form-select form-control">
                    <option value=""></option>
                    @foreach ($suppliers as $row)
                    <option {{ (isset($_GET['supplier_code']) && ($row->supplier_code == $_GET['supplier_code'])) ? 'selected="selected"' : ''; }} value="{{ $row->supplier_code }}">{{ $row->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="supplier_code_name" class="form-select form-control">
                    <option value=""></option>
                    @foreach ($suppliers as $row)
                    <option {{ (isset($_GET['supplier_code']) && ($row->supplier_code == $_GET['supplier_code'])) ? 'selected="selected"' : ''; }} value="{{ $row->supplier_code }}">{{ $row->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-2">
                Status
            </div>
            <div class="col-3">
                <select name="status" class="form-control form-select">
                    <option value="">Semua...</option>
                    <option value="lunas">LUNAS</option>
                    <option value="pending">PENDING</option>
                </select>
                {{-- <select name="payment_type" required="required" class="form-select form-control">
                    <option value="">Semua Status...</option>
                    <option {{ (isset($_GET['status']) && ($_GET['status'] == 'TUNAI')) ? 'selected="selected"' : ''; }} value="TUNAI">TUNAI</option>
                    <option {{ (isset($_GET['status']) && ($_GET['status'] == 'KREDIT')) ? 'selected="selected"' : ''; }} value="KREDIT">KREDIT</option>
                </select> --}}
            </div>
        </div>
    </div>
    <div class="col text-end">
        {{-- <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-file"></i>
            Detail
        </button>
        <button id="paymentButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-circle-dollar-to-slot"></i>
            Bayar
        </button> --}}
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
        <table class="table table-striped print table-condensed selectable" id="itemsTable">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tgl. Invoice</th>
                    <th>Kode Supp.</th>
                    <th>Nama Supplier</th>
                    <th>Jatuh Tempo</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('input').attr('autocomplete', 'off');
        refreshData();
    });

    $('input').on('change paste keyup', function(){
        refreshData();
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData() {
        var invoice_no = $('input[name=invoice_no]').val();
        var date_start = $('input[name=date_start]').val();
        var date_end = $('input[name=date_end]').val();
        var supplier_code = $('select[name=supplier_code]').val();
        var status = $('select[name=status]').val();
        $.ajax({
            url: '{{ url('api/invoice/hutang') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: invoice_no,
                date_start: date_start,
                date_end: date_end,
                supplier_code: supplier_code,
                status: status,
            }
        })
        .done(function(result) {
            $('#itemsTable tbody').html('');
            $.each(result, function(index, val) {
                $('#itemsTable tbody').append('<tr data-id="'+val.invoice_no+'">' +
                    '<td>'+val.invoice_no+'</td>' +
                    '<td>'+val.invoice_date+'</td>' +
                    '<td>'+val.supplier_code+'</td>' +
                    '<td>'+val.supplier_name+'</td>' +
                    '<td>'+val.expiry_date+'</td>' +
                    '<td>'+$.number(val.total_price, 0)+'</td>' +
                    '<td>'+$.number(val.total_paid_amount, 0)+'</td>' +
                    '<td class="fw-bold">'+$.number(val.hutang, 0)+'</td>' +
                    '</tr>');
            });
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(result) {
            console.log(result);
            console.log("complete");
        });
    }

    $('#detailButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/pembelian/invoice/detail') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });

    $('#paymentButton').on('click', function(){
        if (selected_row) {
            window.location.href='{{ url('admin/pembelian/pembayaran/invoice') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Invoice Terlebih Dahulu');
        }
    });
    $('#printButton').on('click', function(){
        var params = {
            invoice_no: $('input[name=invoice_no]').val(),
            date_start: $('input[name=date_start]').val(),
            date_end: $('input[name=date_end]').val(),
            supplier_code: $('select[name=supplier_code]').val(),
            supplier_code_name: $('select[name=supplier_code_name] option:selected').text(),
            status: $('select[name=status]').val(),
        }
        window.open('{{ url('admin/print/buy-hutang-list') }}?' + $.param(params), 'printWindow');
    });

    $('.selectable').on('click', 'tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');

        if (selected_row) {
            window.location.href='{{ url('admin/dashboard/hutang/bayar') }}?invoice_no='+selected_row;
        } else {
            alert('Pilih Data Terlebih Dahulu');
        }
    });
</script>
@endsection