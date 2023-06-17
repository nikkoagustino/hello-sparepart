@extends('admin.template')

@section('meta')
<title>Invoice Penjualan - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}"> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-danger">
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
                Kode Customer
            </div>
            <div class="col-9">
                <input name="customer_code" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                Kode Sales
            </div>
            <div class="col-9">
                <input name="sales_code" readonly="readonly" class="form-control">
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
        <a href="{{ url('admin/penjualan/invoice/list') }}" class="btn btn-danger btn-icon-lg">
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
        <h3>List Pembelian Barang</h3>
        <table class="table table-striped print table-condensed selectable" id="itemsTable">
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
<div class="row mt-3" id="returWrapper">
    <div class="col">
        <h3>List Barang Retur</h3>
        <table class="table table-striped print table-condensed selectable" id="returItemsTable">
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
                    <td class="total_returned_price">
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
        <button id="returButton" data-bs-toggle="modal" data-bs-target="#returModal" class="btn btn-danger btn-icon-lg">
            <img src="{{ url('assets/img/svg/retur.svg') }}">
            Retur
        </button>
        <button id="deleteButton" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-trash"></i>
            Delete
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="returModal" tabindex="-1" aria-labelledby="returModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-danger text-light text-center">
                <p class="py-2">Retur Item</p>
                <div class="row my-2">
                    Kode Barang
                    <select name="returItemCode" class="form-control form-select"></select>
                </div>
                <div class="row my-2">
                    Qty Retur
                    <input type="number" name="retur_qty" class="form-control" value="0" min="1" step="1">
                </div>
                <div class="row my-2">
                    <div class="col">
                        <a class="btn form-control btn-light" id="saveRetur">
                            SIMPAN
                        </a>
                    </div>
                    <div class="col">
                        <button class="btn form-control btn-light" data-bs-dismiss="modal" aria-label="Close">
                            CANCEL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>

    $('input[name=invoice_no]').on('change paste keyup', function(){
        var invoice_no = $(this).val();
        $.ajax({
            url: '{{ url('api/invoice/penjualan') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            $('input[name=invoice_date]').val(result.data.invoice_date);
            $('input[name=days_expire]').val(result.data.days_expire);
            $('input[name=description]').val(result.data.description);
            $('input[name=customer_code]').val(result.data.customer_code + ' - ' + result.data.customer_name).change();
            $('input[name=sales_code]').val(result.data.sales_code + ' - ' + result.data.sales_name).change();
            $('input[name=payment_type]').val(result.data.payment_type);
            $('textarea[name=address]').text(result.data.customer_address);
            getInvoiceItems(invoice_no);
            getReturnedItems(invoice_no);
        })
        .fail(function() {
            $('input[name=invoice_date]').val('');
            $('input[name=days_expire]').val('');
            $('input[name=description]').val('');
            $('input[name=customer_code]').val('').change();
            $('input[name=sales_code]').val('').change();
            $('input[name=payment_type]').val('').change();
            $('textarea[name=address]').text('');
        })
        .always(function(result) {
        });
    });

    function getInvoiceItems(invoice_no) {
        $.ajax({
            url: '{{ url('api/invoice/penjualan/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            var table_row = '';
            var total_invoice_price = 0;
            var retur_dropdown = '';
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
                retur_dropdown += '<option data-max="'+row.qty+'" value="'+row.product_code+'">'+row.product_code+' - '+row.product_name+'</option>';
            });
            $('#itemsTable tbody').html(table_row);
            $('.total_invoice_price').text($.number(total_invoice_price, 0));
            $('select[name=returItemCode]').html(retur_dropdown);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(result) {
            console.log(result);
            console.log("complete");
        });
    }


    function getReturnedItems(invoice_no) {
        $.ajax({
            url: '{{ url('api/penjualan/retur/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            var table_row = '';
            var total_returned_price = 0;
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
                    total_returned_price = total_returned_price + parseInt(row.subtotal_price);
            });
            $('#returItemsTable tbody').html(table_row);
            $('.total_returned_price').text($.number(total_returned_price, 0));
        })
        .fail(function(xhr, result){
            $('#returWrapper').hide();
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
        $('#deleteAction').attr('href', '{{ url('admin/penjualan/invoice/delete-item') }}/'+encodeURIComponent(invoice_no)+'/'+selected_row);
        $("#deleteModal").modal("show");
    });

    @if ($_GET)
    @if ($_GET['invoice_no'])
        $('input[name=invoice_no]').val('{{ $_GET['invoice_no'] }}').trigger('change').attr('readonly', 'readonly');
    @endif
    @endif

    $('#saveRetur').on('click', function(){
        var retur_product_code = $('select[name=returItemCode]').val();
        var max_qty = $('select[name=returItemCode] option:selected').data('max');
        var retur_qty = $('input[name=retur_qty]').val();
        var invoice_no = $('input[name=invoice_no]').val();
        if (retur_qty < 1) {
            alert('Minimal retur qty = 1');
            return;
        }
        if (retur_qty > max_qty) {
            alert('Maksimal retur qty = '+max_qty);
            return;
        }
        $.ajax({
            url: '{{ url('api/penjualan/retur') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                invoice_no: invoice_no,
                product_code: retur_product_code,
                qty: retur_qty
            },
        })
        .done(function(result) {
            if (result.success) {
                alert('Berhasil menyimpan retur');
                window.location.reload();
            }
        });
    });

    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        window.open('{{ url('admin/print/invoice-sell') }}/'+invoice_no, 'printWindow');
    });
</script>
@endsection