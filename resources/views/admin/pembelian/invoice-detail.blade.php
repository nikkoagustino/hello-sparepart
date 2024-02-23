@extends('admin.template')

@section('meta')
<title>Invoice Pembelian - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')

<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <i class="fa-solid fa-boxes"></i> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Invoice
</a>
<a href="{{ url()->current() }}" class="btn btn-danger">
    <img src="{{ url('assets/img/icon/pembelian.svg') }}" alt=""> &nbsp; Pembelian
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
                <input type="text" readonly="readonly" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Tanggal Invoice
            </div>
            <div class="col-3">
                <input type="date" readonly="readonly" name="invoice_date" class="form-control">
            </div>
            <div class="col-1">s/d</div>
            <div class="col-3">
                <input type="date" readonly="readonly" name="invoice_date" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Kode Supplier
            </div>
            <div class="col-3">
                <select name="supplier_code" readonly="readonly" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <select name="supplier_code_name" readonly="readonly" required="required" class="form-select form-control">
                    <option value="" selected="selected" disabled="disabled"></option>
                    @foreach ($suppliers as $row)
                    <option value="{{ $row->supplier_code }}">{{ $row->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Alamat
            </div>
            <div class="col-9">
                <textarea name="address" rows="3" readonly="readonly" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Jatuh Tempo
            </div>
            <div class="col-2">
                <input name="days_expire" readonly="readonly" class="form-control">
            </div>
            <div class="col-1">
                Hari
            </div>
            <div class="col-1">
                Ket
            </div>
            <div class="col-5">
                <input name="description" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Status
            </div>
            <div class="col-3">
                <input name="payment_type" readonly="readonly" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        {{-- <a href="{{ url('admin/penjualan/invoice/list') }}" class="btn btn-danger btn-icon-lg">
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
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
<div class="row mt-2 mb-5">
    <div class="col">
        <button id="editButton" data-bs-toggle="modal" data-bs-target="#pinModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
        <button id="deleteInvoiceButton" data-bs-toggle="modal" data-bs-target="#deleteModal" data-target-function="deleteInvoice" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-trash"></i>
            Delete
        </button>
        <button id="newItemButton" style="display: none" data-bs-toggle="modal" data-bs-target="#newItemModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus-circle"></i>
            New
        </button>
        <button id="returButton" style="display: none" data-bs-toggle="modal" data-bs-target="#returModal" class="btn btn-danger btn-icon-lg">
            <img src="{{ url('assets/img/svg/retur.svg') }}">
            Retur
        </button>
    </div>
    <div class="col-1">Total</div>
    <div class="col-3">
        <input type="text" readonly="readonly" class="form-control bg-khaki" name="total_invoice_price">
    </div>
</div>

<div class="row mt-3" id="returWrapper" style="display: none">
    <div class="col-12">
        <div class="breadcrumb">
            <div class="row pt-3">
                <div class="col">
                    <a href="{{ url()->current() }}" class="btn btn-danger">
                        <img src="{{ url('assets/img/svg/retur.svg') }}"> &nbsp; Retur
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
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
        </table>
    </div>
    <div class="col"></div>
    <div class="col-1">Total</div>
    <div class="col-3">
        <input type="text" data-type="number" readonly="readonly" class="form-control bg-khaki" name="total_returned_price">
    </div>
</div>

<!-- Modal -->
<div class="modal modal-lg fade" id="returModal" tabindex="-1" aria-labelledby="returModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb">
                            <div class="row pt-3">
                                <div class="col">
                                    <a href="{{ url()->current() }}" class="btn btn-danger">
                                        <img src="{{ url('assets/img/svg/retur.svg') }}"> &nbsp; Retur
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button id="saveRetur" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button id="returItemBack" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">Kode Barang</div>
                    <div class="col-6">
                        <select name="returItemCode" class="form-control form-select"></select>
                    </div>
                </div>
                <div class="row mt-2 mb-5 pb-5">
                    <div class="col-2">Qty</div>
                    <div class="col-4">
                        <input name="returQty" type="number" step="1" min="1" value="1" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb">
                            <div class="row pt-3">
                                <div class="col">
                                    <a href="{{ url()->current() }}" class="btn btn-danger">
                                        <i class="fa-solid fa-pencil"></i> &nbsp; Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button id="editItemSave" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button id="editItemDelete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-target-function="deleteItem" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                        <button id="editItemBack" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        Kode Barang
                    </div>
                    <div class="col-3">
                        <input type="text" readonly="readonly" class="form-control" name="edit_item_product_code">
                    </div>
                    <div class="col-2">
                        <input type="text" readonly="readonly" class="form-control" name="edit_item_product_type_code">
                    </div>
                    <div class="col-5">
                        <input type="text" readonly="readonly" class="form-control" name="edit_item_product_name">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Harga
                    </div>
                    <div class="col-3">
                        <input type="text" data-type="number" class="form-control" name="edit_item_normal_price">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Discount
                    </div>
                    <div class="col-3">
                        <input type="number" step="0.1" class="form-control" name="edit_item_discount_rate">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Qty
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control" name="edit_item_qty">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Harga Discount
                    </div>
                    <div class="col-3">
                        <input type="text" data-type="number" class="form-control" name="edit_item_discount_price">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Total
                    </div>
                    <div class="col-3">
                        <input type="text" readonly="readonly" data-type="number" class="form-control" name="edit_item_subtotal_price">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-lg fade" id="newItemModal" tabindex="-1" aria-labelledby="newItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb">
                            <div class="row pt-3">
                                <div class="col">
                                    <a href="{{ url()->current() }}" class="btn btn-danger">
                                        <i class="fa-solid fa-plus-circle"></i> &nbsp; New
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button id="newItemSave" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button id="newItemBack" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-2">Kode Barang</div>
                    <div class="col-3 position-relative">
                        <input type="text" name="new_item_product_code" class="form-control">
                        <ul class="floating-select" id="product_code_list"></ul>
                    </div>
                    <div class="col-2">
                        <input type="text" name="new_item_product_type_code" readonly="readonly" class="form-control">
                    </div>
                    <div class="col-5 position-relative">
                        <input type="text" name="new_item_product_name" class="form-control">
                        <ul class="floating-select" id="product_name_list"></ul>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Harga
                    </div>
                    <div class="col-3">
                        <input type="text" data-type="number" class="form-control" name="new_item_normal_price">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Discount
                    </div>
                    <div class="col-3">
                        <input type="number" step="0.1" class="form-control" name="new_item_discount_rate">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Qty
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control" name="new_item_qty">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Harga Discount
                    </div>
                    <div class="col-3">
                        <input type="text" data-type="number" class="form-control" name="new_item_discount_price">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        Total
                    </div>
                    <div class="col-3">
                        <input type="text" readonly="readonly" data-type="number" class="form-control" name="new_item_subtotal_price">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var deleteTargetFunction = '';
    $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
        deleteTargetFunction = $(this).data('target-function');
    });

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
            $('select[name=supplier_code]').val(result.data.supplier_code).change();
            $('input[name=payment_type]').val(result.data.payment_type);
            $('textarea[name=address]').text(result.data.supplier_address);
            getInvoiceItems(invoice_no);
            getReturnedItems(invoice_no);
        })
        .fail(function() {
            $('input[name=invoice_date]').val('');
            $('input[name=days_expire]').val('');
            $('input[name=description]').val('');
            $('select[name=supplier_code]').val('').change();
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
            $('input[name=total_invoice_price]').val($.number(total_invoice_price, 0));
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
                table_row += '<tr data-id="'+row.id+'">' +
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
            $('input[name=total_returned_price]').val(total_returned_price).change();
            $('#returWrapper').show();
        })
        .fail(function(xhr, result){
            $('#returWrapper').hide();
        });
    }
    
    function enableEdit() {
        var invoice_no = $('input[name=invoice_no]').val();
        if (!invoice_no) {
            alert('Pilih invoice terlebih dahulu');
            $('#editButton').show();
            return;
        }
        $('input').removeAttr('readonly');
        $('input[name=invoice_no]').attr('readonly', 'readonly');
        $('select').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('#newItemButton').show();
        $('#deleteInvoiceButton').hide();
        $('#returButton').show();
        $('#itemsTable').addClass('selectable');
    }

    $('body').on('click', '#itemsTable.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');

        if (selected_row) {
            $('input[name=edit_item_product_code]').val($(this).find('td:nth-child(1)').text());
            $('input[name=edit_item_product_type_code]').val($(this).find('td:nth-child(2)').text());
            $('input[name=edit_item_product_name]').val($(this).find('td:nth-child(3)').text());
            $('input[name=edit_item_qty]').val($(this).find('td:nth-child(4)').text());
            var normal_price = parseInt(($(this).find('td:nth-child(5)').text()).replace(/,/g, ''));
            var discount_rate = parseFloat(($(this).find('td:nth-child(6)').text()).replace(/,/g, ''));
            var subtotal_price = parseInt(($(this).find('td:nth-child(7)').text()).replace(/,/g, ''));
            $('input[name=edit_item_normal_price]').val(normal_price).change();
            $('input[name=edit_item_discount_rate]').val(discount_rate).change();
            $('input[name=edit_item_discount_price]').val(normal_price - (normal_price * (discount_rate / 100))).change();
            $('input[name=edit_item_subtotal_price]').val(subtotal_price).change();
            $('#editItemModal').modal('show');
        } else {
            alert('Pilih Data Terlebih Dahulu');
        }
    });

    $('input[name=edit_item_normal_price]').on('keyup', function(){
        var normal_price = parseInt($(this).val().replace(/,/g, ''));
        var discount_rate = parseFloat($('input[name=edit_item_discount_rate]').val().replace(/,/g, ''));
        var qty = parseInt($('input[name=edit_item_qty]').val().replace(/,/g, ''));
        var discount_price = normal_price - (normal_price * (discount_rate / 100));
        var subtotal_price = qty * discount_price;
        // $('input[name=edit_item_normal_price]').val(normal_price).change();
        $('input[name=edit_item_discount_rate]').val(discount_rate).change();
        $('input[name=edit_item_discount_price]').val(discount_price).change();
        $('input[name=edit_item_subtotal_price]').val(subtotal_price).change();
        $('input[name=edit_item_qty]').val(qty).change();
    });

    $('input[name=edit_item_discount_rate]').on('click keyup', function(){
        var discount_rate = parseFloat($(this).val().replace(/,/g, ''));
        var normal_price = parseInt($('input[name=edit_item_normal_price]').val().replace(/,/g, ''));
        var qty = parseInt($('input[name=edit_item_qty]').val().replace(/,/g, ''));
        var discount_price = normal_price - (normal_price * (discount_rate / 100));
        var subtotal_price = qty * discount_price;
        // $('input[name=edit_item_normal_price]').val(normal_price).change();
        $('input[name=edit_item_discount_rate]').val(discount_rate).change();
        $('input[name=edit_item_discount_price]').val(discount_price).change();
        $('input[name=edit_item_subtotal_price]').val(subtotal_price).change();
        $('input[name=edit_item_qty]').val(qty).change();
    });

    $('input[name=edit_item_discount_price]').on('keyup', function(){
        var discount_price = parseFloat($(this).val().replace(/,/g, ''));
        var normal_price = parseInt($('input[name=edit_item_normal_price]').val().replace(/,/g, ''));
        var discount_rate = ((normal_price - discount_price) / normal_price) * 100;
        var qty = parseInt($('input[name=edit_item_qty]').val().replace(/,/g, ''));
        var subtotal_price = qty * discount_price;
        // $('input[name=edit_item_normal_price]').val(normal_price).change();
        $('input[name=edit_item_discount_rate]').val(discount_rate).change();
        $('input[name=edit_item_discount_price]').val(discount_price).change();
        $('input[name=edit_item_subtotal_price]').val(subtotal_price).change();
        $('input[name=edit_item_qty]').val(qty).change();
    });

    $('input[name=edit_item_qty]').on('click keyup', function(){
        var qty = parseInt($(this).val().replace(/,/g, ''));
        var normal_price = parseInt($('input[name=edit_item_normal_price]').val().replace(/,/g, ''));
        var discount_rate = parseFloat($('input[name=edit_item_discount_rate]').val().replace(/,/g, ''));
        var discount_price = normal_price - (normal_price * (discount_rate / 100));
        var subtotal_price = qty * discount_price;
        // $('input[name=edit_item_normal_price]').val(normal_price).change();
        $('input[name=edit_item_discount_rate]').val(discount_rate).change();
        $('input[name=edit_item_discount_price]').val(discount_price).change();
        $('input[name=edit_item_subtotal_price]').val(subtotal_price).change();
        $('input[name=edit_item_qty]').val(qty).change();
    });

    $('#editItemBack').on('click', function(){
        $('#editItemModal').modal('hide');
    });

    $('#returItemBack').on('click', function(){
        $('#returModal').modal('hide');
    });

    $('#newItemBack').on('click', function(){
        $('#newItemModal').modal('hide');
    });

    $('#editItemSave').on('click', function(){
        $.ajax({
            url: '{{ url('api/penjualan/edit-item') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                invoice_no: $('input[name=invoice_no]').val(),
                product_code: $('input[name=edit_item_product_code]').val(),
                normal_price: parseInt($('input[name=edit_item_normal_price]').val().replace(/,/g, '')),
                discount_rate: $('input[name=edit_item_discount_rate]').val(),
                discounted_price: parseInt($('input[name=edit_item_discount_price]').val().replace(/,/g, '')),
                qty: $('input[name=edit_item_qty]').val(),
                subtotal_price: parseInt($('input[name=edit_item_subtotal_price]').val().replace(/,/g, '')),
            },
        })
        .done(function(result) {
            if (result.success) {
                $('#editItemModal').modal('hide');
                $('input[name=invoice_no]').trigger('change');
            } else {
                console.log(result);
            }
        });
    });

    function enableDelete() {
        console.log(deleteTargetFunction);
        if (deleteTargetFunction === 'deleteItem') {
            $.ajax({
                url: '{{ url('api/pembelian/delete-item') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    invoice_no: $('input[name=invoice_no]').val(),
                    product_code: $('input[name=edit_item_product_code]').val(),
                },
            })
            .done(function(result) {
                if (result.success) {
                    $('input[name=invoice_no]').trigger('change');
                } else {
                    alert(result);
                }
            });
        } else if (deleteTargetFunction === 'deleteInvoice') {
            window.location.href = '{{ url('admin/dashboard/invoice/pembelian/delete') }}?invoice_no='+$('input[name=invoice_no]').val();
        }
    }

    @if ($_GET)
    @if ($_GET['invoice_no'])
        $('input[name=invoice_no]').val('{{ $_GET['invoice_no'] }}').trigger('change').attr('readonly', 'readonly');
    @endif
    @endif

    $('#saveRetur').on('click', function(){
        var retur_product_code = $('select[name=returItemCode]').val();
        var max_qty = $('select[name=returItemCode] option:selected').data('max');
        var retur_qty = $('input[name=returQty]').val();
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
                $('#returModal').modal('hide');
                $('input[name=invoice_no]').trigger('change');
            }
        });
    });



    // create product finder
    var products = JSON.parse('{!! json_encode($products) !!}');
    $('input[name=new_item_product_code]').on('change paste keyup', function(){
        var product_code_filtered = [];
        var search_term = $(this).val();
        $('#product_code_list').html('');
        $.each(products, function(index, val) {
            if (val.product_code.toLowerCase().indexOf(search_term.toLowerCase()) >= 0) {
                product_code_filtered.push(val);
                $('#product_code_list').append('<li>'+ val.product_code +'</li>');
            }
        });
    });
    $('input[name=new_item_product_name]').on('change paste keyup', function(){
        var product_code_filtered = [];
        var search_term = $(this).val();
        $('#product_name_list').html('');
        $.each(products, function(index, val) {
            if (val.product_name.toLowerCase().indexOf(search_term.toLowerCase()) >= 0) {
                product_code_filtered.push(val);
                $('#product_name_list').append('<li data-code="'+ val.product_code +'">'+ val.product_name +'</li>');
            }
        });
    });

    $('#product_code_list').on('click', 'li', function() {
        selected_product_code = $(this).html();
        $(this).text(selected_product_code);
        selectProduct(selected_product_code);
    });
    $('#product_name_list').on('click', 'li', function() {
        selected_product_code = $(this).data('code');
        $('input[name=new_item_product_code]').text(selected_product_code);
        selectProduct(selected_product_code);
    });

    function selectProduct(product_code) {
        $('.floating-select').html('');
        $.ajax({
            url: '{{ url('api/product') }}',
            type: 'GET',
            dataType: 'json',
            data: {product_code: product_code},
        })
        .done(function(result) {
            $('input[name=new_item_product_code]').val(result.data.product_code);
            $('input[name=new_item_product_name]').val(result.data.product_name);
            $('input[name=new_item_product_type_code]').val(result.data.type_code).attr('readonly', 'readonly');
            normal_price = result.data.price_selling;
            $('input[name=new_item_normal_price]').val(normal_price);
            calculatePrice();
        });
    }

    $('input[name=new_item_discount_rate]').on('change paste keyup', function(){
        calculatePrice();
    });

    $('input[name=new_item_qty]').on('change paste keyup', function(){
        calculatePrice();
    });

    function calculatePrice() {
        var discount_rate = $('input[name=new_item_discount_rate]').val();
        var discounted_price = parseInt(normal_price - (normal_price * (parseFloat(discount_rate) / 100)));
        var qty = $('input[name=new_item_qty]').val();
        var subtotal_price = parseInt(discounted_price * qty);

        $('input[name=new_item_discount_price]').val(discounted_price);
        $('input[name=new_item_subtotal_price]').val(subtotal_price);
        $('input[data-type=number]').trigger('change');
    }

    $('#newItemSave').on('click', function(){
        $.ajax({
            url: '{{ url('api/penjualan/add-item') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                invoice_no: $('input[name=invoice_no]').val(),
                product_code: $('input[name=new_item_product_code]').val(),
                normal_price: parseInt($('input[name=new_item_normal_price]').val().replace(/,/g, '')),
                discount_rate: $('input[name=new_item_discount_rate]').val(),
                discounted_price: parseInt($('input[name=new_item_discount_price]').val().replace(/,/g, '')),
                qty: $('input[name=new_item_qty]').val(),
                subtotal_price: parseInt($('input[name=new_item_subtotal_price]').val().replace(/,/g, '')),
            },
        })
        .done(function(result) {
            if (result.success) {
                $('#newItemModal').modal('hide');
                $('input[name=invoice_no]').trigger('change');
            } else {
                alert(result);
            }
        });
    });


    $('body').on('click', '#returItemsTable.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/dashboard/invoice/penjualan/retur') }}?id="+selected_row;
    });

    // before revision below

    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        window.open('{{ url('admin/print/invoice-sell') }}?invoice_no='+invoice_no, 'printWindow');
    });
</script>
@endsection