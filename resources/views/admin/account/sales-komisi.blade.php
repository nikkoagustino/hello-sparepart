@extends('admin.template')

@section('meta')
<title>Komisi Sales - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/sales') }}" class="btn btn-danger">
    <i class="fa-solid fa-headset"></i> &nbsp; Sales
</a>
<a href="{{ url('admin/account/sales/komisi') }}" class="btn btn-danger">
    <i class="fa-solid fa-dollar-sign"></i> &nbsp; Komisi
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
        <table class="table table-striped print" id="invoice_table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tgl. Invoice</th>
                    <th>Tgl. Pembayaran</th>
                    <th>Nama Toko / Customer</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mt-2">
    <div class="col-4">
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
        <div class="row">
            <div class="col-4">
                Profit
            </div>
            <div class="col">
                <input type="text" data-type="number" name="profit" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4">
                Komisi
            </div>
            <div class="col">
                <div class="input-group">
                    <input type="number" step="0.1" name="komisi_persen" readonly="readonly" class="form-control text-end">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-4">
                Total Invoice
            </div>
            <div class="col">
                <input type="number" name="total_invoice" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4">
                Total Komisi
            </div>
            <div class="col">
                <input type="number" name="total_komisi" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData(){
        var sales_code = $('select[name=sales_code]').val();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        if (sales_code && year && month) {
            $.ajax({
                url: '{{ url('api/komisi') }}',
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

    var komisi_persen = 0;
    var total_komisi = 0;
    var total_invoice_price = 0;

    function processData(result) {
        total_invoice_price = 0;
        total_komisi = 0;
        var table_row = '';
        $.each(result.invoices, function(index, row) {
            table_row += '<tr data-id="'+index+'">' +
                '<td>'+row.invoice_no+'</td>' +
                '<td>'+row.invoice_date+'</td>' +
                '<td>'+row.payment_date+'</td>' +
                '<td>'+row.customer_name+'</td>' +
                '<td>'+$.number(row.paid_amount, 0)+'</td>' +
                '</tr>';
                total_invoice_price = total_invoice_price + parseInt(row.paid_amount);
        });
        $('#invoice_table tbody').html(table_row);
        $('input[name=total_invoice]').val(total_invoice_price).change();
        komisi_persen = parseFloat(result.percent_komisi);
        total_komisi = Math.ceil(total_invoice_price * (komisi_persen / 100));
        $('input[name=komisi_persen]').val(komisi_persen);
        $('input[name=total_komisi]').val(total_komisi).change();
    }

    function enableEdit() {
        $('input[name=komisi_persen]').removeAttr('readonly');
        $('input[name=total_komisi]').removeAttr('readonly');
    }

    $('input[name=komisi_persen]').on('change paste keyup', function(){
        komisi_persen = parseFloat($(this).val());
        total_komisi = Math.ceil(total_invoice_price * (komisi_persen / 100));
        $('input[name=komisi_persen]').val(komisi_persen);
        $('input[name=total_komisi]').val(total_komisi);
    });

    $('input[name=total_komisi]').on('change paste keyup', function(){
        total_komisi = parseInt($(this).val());
        komisi_persen = (total_komisi / total_invoice_price) * 100;
        $('input[name=total_komisi]').val(total_komisi);
        $('input[name=komisi_persen]').val(komisi_persen);
    });

    $('#saveButton').on('click', function(){
        var sales_code = $('select[name=sales_code]').val();
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        var new_komisi_persen = $('input[name=komisi_persen]').val();
        console.log([sales_code, year, month, new_komisi_persen]);
        $.ajax({
            url: '{{ url('api/komisi/save') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                sales_code: sales_code,
                year: parseInt(year),
                month: parseInt(month),
                persen_komisi: parseFloat(new_komisi_persen)
            },
        })
        .done(function(result) {
            if (result.success) {
                $('input[name=komisi_persen]').attr('readonly', 'readonly');
                $('input[name=total_komisi]').attr('readonly', 'readonly');
                $('#editButton').show();
                $('#saveButton').hide();
            }
            alert(result.message);
        });
    });

    $('#printButton').on('click', function(){
        var params = {
            sales_code: $('select[name=sales_code]').val(),
            year: $('select[name=year]').val(),
            month: $('select[name=month]').val()
        }
        window.open('{{ url('admin/print/komisi-sales') }}?' + $.param(params), 'printWindow');
    });
</script>
@endsection