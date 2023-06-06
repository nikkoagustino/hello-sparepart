@extends('admin.template')

@section('meta')
<title>Invoice Pembelian - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/invoice-list.svg') }}"> &nbsp; Invoice
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">
                No Invoice
            </div>
            <div class="col-9">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-9">
                <input type="date" readonly="readonly" name="invoice_date" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Supplier
            </div>
            <div class="col-9">
                <input name="supplier_code" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Alamat
            </div>
            <div class="col-9">
                <textarea name="address" rows="3" readonly="readonly" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Jatuh Tempo
            </div>
            <div class="col-3">
                <input name="days_expire" readonly="readonly" class="form-control">
            </div>
            <div class="col-3">
                Hari
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Keterangan
            </div>
            <div class="col-9">
                <input name="description" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Status
            </div>
            <div class="col-9">
                <input name="payment_type" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        <a href="{{ url('admin/pembelian/invoice/list') }}" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-receipt"></i>
            List
        </a>
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
        <table class="table table-striped table-condensed selectable" id="itemsTable">
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

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">Total</td>
                    <td class="total_invoice_price">
                    0
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row mt-2 mb-5">
    <div class="col">
        <button id="editButton" data-bs-toggle="modal" data-bs-target="#pinModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
        <button id="deleteButton" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-trash"></i>
            Delete
        </button>
    </div>
</div>

@endsection
@section('script')
<script>

    $('input[name=invoice_no]').on('change paste keyup', function(){
        var invoice_no = $(this).val();
        $.ajax({
            url: '{{ url('api/invoice/pembelian') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            $('input[name=invoice_date]').val(result.data.invoice_date);
            $('input[name=days_expire]').val(result.data.days_expire);
            $('input[name=description]').val(result.data.description);
            $('input[name=supplier_code]').val(result.data.supplier_code + ' - ' + result.data.supplier_name).change();
            $('input[name=payment_type]').val(result.data.payment_type);
            $('textarea[name=address]').text(result.data.supplier_address);
            getInvoiceItems(invoice_no);
        })
        .fail(function() {
            $('input[name=invoice_date]').val('');
            $('input[name=days_expire]').val('');
            $('input[name=description]').val('');
            $('input[name=supplier_code]').val('').change();
            $('input[name=payment_type]').val('').change();
            $('textarea[name=address]').text('');
        })
        .always(function(result) {
        });
    });

    function getInvoiceItems(invoice_no) {
        $.ajax({
            url: '{{ url('api/invoice/pembelian/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            var table_row = '';
            var total_invoice_price = 0;
            $.each(result.data, function(index, row) {
                table_row += '<tr data-id="'+row.product_code+'">' +
                    '<td>'+row.product_code+'</td>' +
                    '<td>'+row.type_code+'</td>' +
                    '<td>'+row.product_name+'</td>' +
                    '<td>'+$.number(row.qty, 0)+'</td>' +
                    '<td>'+$.number(row.normal_price, 0)+'</td>' +
                    '<td>'+$.number(row.discount_rate, 2)+'</td>' +
                    '<td>'+$.number(row.subtotal_price, 0)+'</td>' +
                    '</tr>';
                    total_invoice_price = total_invoice_price + parseInt(row.subtotal_price);
            });
            $('#itemsTable tbody').html(table_row);
            $('.total_invoice_price').text($.number(total_invoice_price, 0));
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(result) {
            console.log(result);
            console.log("complete");
        });
    }

    $('#editButton').on('click', function(){
        // if (!selected_row) {
        //     alert('Pilih produk terlebih dahulu');
        //     return;
        // }

    });

    $('#deleteButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        if (!selected_row) {
            alert('Pilih produk terlebih dahulu');
            return;
        }
        $('#deleteAction').attr('href', '{{ url('admin/pembelian/invoice/delete-item') }}/'+invoice_no+'/'+selected_row);
        $("#deleteModal").modal("show");
    });

    @if ($_GET)
    @if ($_GET['invoice_no'])
        $('input[name=invoice_no]').val('{{ $_GET['invoice_no'] }}').trigger('change').attr('readonly', 'readonly');
    @endif
    @endif
</script>
@endsection