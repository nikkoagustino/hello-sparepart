@extends('admin.template')

@section('meta')
<title>Pembelian - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/retur') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/retur.svg') }}"> &nbsp; Retur
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-9">
        <div class="row">
            <div class="col-3">No. Invoice</div>
            <div class="col-7">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Tanggal Invoice</div>
            <div class="col-3">
                <input type="date" name="date_start" class="form-control">
            </div>
            <div class="col-1">s/d</div>
            <div class="col-3">
                <input type="date" name="date_end" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Kode Supplier</div>
            <div class="col-3">
                <select name="supplier_code" class="form-select form-control">
                    <option value=""></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="supplier_code_name" class="form-select form-control">
                    <option value=""></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col text-end">
        {{-- <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-arrow-pointer"></i>
            Detail
        </button>
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button> --}}
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tgl. Invoice</th>
                    <th>Kode Supp.</th>
                    <th>Nama Supplier</th>
                    <th>Jatuh Tempo</th>
                    <th>Qty Beli</th>
                    <th>Qty Retur</th>
                    <th>Total Retur</th>
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
    <div class="col"></div>
    <div class="col-1">Total</div>
    <div class="col-2">
        <input type="text" name="sum_retur_price" readonly="readonly" class="form-control bg-khaki">
    </div>
</div>
@endsection
@section('script')
<script>
    $('input').on('change keyup', function(){
        refreshData();
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData() {
        $.ajax({
            url: '{{ url('api/pembelian/transaksi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_no: $('input[name=invoice_no]').val(),
                date_start: $('input[name=date_start]').val(),
                date_end: $('input[name=date_end]').val(),
                supplier_code: $('select[name=supplier_code]').val(),
            },
        })
        .done(function(result) {
            $('tbody').html('');
            var sum_retur_price = 0;
            $.each(result, function(index, val) {
                var inv_date = new Date(val.invoice_date);
                var exp_date = new Date(val.expiry_date);
                var newRow = '<tr data-id="'+val.invoice_no+'">'+
                                '<td>'+val.invoice_no+'</td>'+
                                '<td>'+inv_date.toString('dd-MM-yyyy')+'</td>'+
                                '<td>'+val.supplier_code+'</td>'+
                                '<td>'+val.supplier_name+'</td>'+
                                '<td>'+exp_date.toString('dd-MM-yyyy')+'</td>'+
                                '<td>'+val.total_qty+'</td>'+
                                '<td>'+val.total_retur_qty+'</td>'+
                                '<td>'+$.number(val.total_retur_price, 0)+'</td>'+
                                '</tr>';
                $('tbody').append(newRow);
                sum_retur_price += parseInt(val.total_retur_price);
            });
            $('input[name=sum_retur_price]').val($.number(sum_retur_price, 0));
        });
        
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/pembelian/retur/detail') }}?invoice_no="+selected_row;
    });
    // $('#detailButton').on('click', function(){
    //     if (!selected_row) {
    //         alert('Pilih invoice terlebih dahulu');
    //         return;
    //     }
    //     window.location.href="{{ url('admin/pembelian/invoice/detail') }}?invoice_no="+selected_row;
    // });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/buy-retur-list') }}', 'printWindow');
    });
</script>
@endsection