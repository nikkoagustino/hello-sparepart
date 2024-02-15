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
<div class="row">
    <div class="col-8">
        <div class="row mt-3">
            <div class="col-2">
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
            <div class="col-2">
                Bulan
            </div>
            <div class="col-4">
                <select name="month" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    <option value="1">JANUARI (1)</option>
                    <option value="2">FEBRUARI (2)</option>
                    <option value="3">MARET (3)</option>
                    <option value="4">APRIL (4)</option>
                    <option value="5">MEI (5)</option>
                    <option value="6">JUNI (6)</option>
                    <option value="7">JULI (7)</option>
                    <option value="8">AGUSTUS (8)</option>
                    <option value="9">SEPTEMBER (9)</option>
                    <option value="10">OKTOBER (10)</option>
                    <option value="11">NOVEMBER (11)</option>
                    <option value="12">DESEMBER (12)</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2">
                Nama Sales
            </div>
            <div class="col-4">
                <select name="sales_code_name" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($sales as $row)
                    <option value="{{ $row->sales_code }}">{{ $row->sales_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 pt-2">
                Tahun
            </div>
            <div class="col-4">
                <select name="year" class="form-control form-select">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @for ($i = config('user.MIN_YEAR'); $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="col-4 text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus-circle"></i>
            New
        </button>
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
<div class="row mt-4">
    <div class="col">
        <table class="table table-striped print selectable" id="invoice_table">
            <thead>
                <tr>
                    <th>Kode Sales</th>
                    <th>Nama Sales</th>
                    <th>Tanggal</th>
                    {{-- <th>Jenis</th> --}}
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-2">
   {{--  <div class="col-4">
        <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-save"></i>
            Save
        </button>
        <button id="editButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
    </div>
    <div class="col-4">
    </div> --}}
    <div class="col"></div>
    <div class="col-4">
        <div class="row">
            <div class="col-5">
                Total Invoice
            </div>
            <div class="col">
                <input type="text" data-type="number" name="total_invoice" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function newButton() {
        var sales_code = $('select[name=sales_code]').val();
        if (!sales_code) {
            alert('Pilih sales terlebih dahulu');
            return;
        }
        window.location.href = "{{ url('admin/account/sales/transaksi/new') }}?sales_code="+sales_code; 
    }

    $('select[name=sales_code_name]').on('change', function(){
        $('select[name=sales_code]').val($(this).val());
    });
    $('select[name=sales_code]').on('change', function(){
        $('select[name=sales_code_name]').val($(this).val());
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData(){
        var sales_code = $('select[name=sales_code]').val();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        if (sales_code && year && month) {
            $.ajax({
                url: '{{ url('api/transaksi') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    sales_code: sales_code,
                    year: year,
                    month: month
                },
            })
            .done(function(result) {
                processData(result);
            });
        } else {
            console.log('incomplete selection');
        }
    }


    function processData(result) {
        var total_invoice_price = 0;
        var table_row = '';
        $.each(result, function(index, row) {
            table_row += '<tr data-id="'+row.id+'">' +
                '<td>'+row.sales_code+'</td>' +
                '<td>'+row.sales_name+'</td>' +
                '<td>'+row.tx_date+'</td>' +
                '<td>'+$.number(row.amount, 0)+'</td>' +
                '</tr>';
                total_invoice_price = total_invoice_price + parseInt(row.amount);
        });
        $('#invoice_table tbody').html(table_row);
        $('input[name=total_invoice]').val(total_invoice_price).change();
    }

    $('.selectable').on('click', 'tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');

        if (selected_row) {
            window.location.href='{{ url('admin/account/sales/transaksi/detail') }}/'+selected_row;
        } else {
            alert('Pilih Admin Terlebih Dahulu');
        }
    });

    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/account/sales/transaksi/new') }}';
    });

    $('#printButton').on('click', function(){
        var params = {
            sales_code: $('select[name=sales_code]').val(),
            year: $('select[name=year]').val(),
            month: $('select[name=month]').val()
        }
        window.open('{{ url('admin/print/transaksi-sales') }}?' + $.param(params), 'printWindow');
    });
</script>
@endsection