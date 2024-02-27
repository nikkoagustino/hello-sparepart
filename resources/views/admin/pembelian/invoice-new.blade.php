@extends('admin.template')

@section('meta')
<title>Buat Invoice - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/pembelian') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}"> &nbsp; Pembelian
</a>
<a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/invoice-list.svg') }}"> &nbsp; Invoice
</a>
<a href="{{ url('admin/pembelian/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-plus-circle"></i> &nbsp; Invoice Baru
</a>
@endsection

@section('content')
<form action="{{ url('admin/pembelian/invoice/new') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-3">
                    No. Invoice
                </div>
                <div class="col-6">
                    <input name="invoice_no" required="required" type="text" class="form-control">
                    {{-- <div class="input-group">
                        <button class="btn btn-danger btn-form" type="button" id="generateInvoiceNo">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div> --}}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Tanggal Invoice
                </div>
                <div class="col-6">
                    <input name="invoice_date" required="required" type="date" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
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

            <div class="row mt-2">
                <div class="col-3">
                    Jatuh Tempo
                </div>
                <div class="col-2">
                    <input name="days_expire" type="number" step="1" class="form-control">
                </div>
                <div class="col-1">
                    Hari
                </div>
                <div class="col-1">
                    Ket
                </div>
                <div class="col-5">
                    <input name="description" type="text" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    Status
                </div>
                <div class="col-3">
                    <select name="payment_type" required="required" class="form-select form-control">
                        <option value="" disabled="disabled" selected="selected">Pilih Status...</option>
                        <option value="TUNAI">TUNAI</option>
                        <option value="KREDIT">KREDIT</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-4 text-end">
            <div class="inputWrapper"></div>
            <button type="submit" id="saveInvoiceButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button>
            <input type="hidden" name="is_print" value="0">
            <button id="saveAndPrintButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga/pc</th>
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
        <div class="col-6">
            <button id="addItemButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-plus-circle"></i>
                New
            </button>
        </div>
        <div class="col text-end">Total</div>
        <div class="col-3">
            <input type="text" data-type="number" value="0" name="total_price" class="form-control bg-khaki" readonly="readonly">
        </div>
    </div>
</form>


<div class="modal modal-lg fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb">
                            <div class="row">
                                <div class="col">
                                    <a href="javascript:void(0)" class="btn btn-danger">
                                        <i class="fa-solid fa-plus-circle"></i> &nbsp; New
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button id="submitAddItem" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-save"></i>
                            Save
                        </button>
                        <button id="backAddItem" class="btn btn-danger btn-icon-lg">
                            <i class="fa-solid fa-rotate-left"></i>
                            Back
                        </button>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-3">Kode Barang</div>
                    <div class="col-3 position-relative">
                        <input type="text" name="product_code" class="form-control">
                        <ul class="floating-select" id="product_code_list"></ul>
                    </div>
                    <div class="col-2">
                        <input type="text" name="type_code" readonly="readonly" class="form-control">
                    </div>
                    <div class="col-4 position-relative">
                        <input type="text" name="product_name" class="form-control">
                        <ul class="floating-select" id="product_name_list"></ul>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-3">Harga</div>
                    <div class="col-3">
                        <input type="text" data-type="number" name="normal_price" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-3">Discount</div>
                    <div class="col-3">
                        <input type="number" step="0.01" value="0" name="discount_rate" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-3">Harga Discount</div>
                    <div class="col-3">
                        <input type="text" data-type="number" name="discounted_price" readonly="readonly" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-3">Qty</div>
                    <div class="col-3">
                        <input type="number" name="qty" value="1" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-3">Total</div>
                    <div class="col-3">
                        <input type="text" data-type="number" name="subtotal_price" readonly="readonly" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                

@endsection

@section('script')
<script>
    var is_item_added = false;
    var total_price = 0;
    var row_counter = 0;

    $('#addItemButton').on('click', function(){
        event.preventDefault();
        $('#addItemModal').modal('show');
    })
    $('#backAddItem').on('click', function(){
        resetAddItemModal();
    });

    $('#saveAndPrintButton').on('click', function(){
        event.preventDefault();
        $('input[name=is_print]').val(1);
        $('#saveInvoiceButton').trigger('click');
    });

    $('#submitAddItem').on('click', function(){
        if (!is_item_added) {
            $('tbody').html('');
            is_item_added = true;
        }
        var product_code = $('input[name=product_code]').val();
        var type_code = $('input[name=type_code]').val();
        var product_name = $('input[name=product_name]').val();
        var normal_price = $('input[name=normal_price]').val().replace(/,/g, '');
        var discount_rate = $('input[name=discount_rate]').val();
        var qty = $('input[name=qty]').val();
        var discounted_price = $('input[name=discounted_price]').val().replace(/,/g, '');
        var subtotal_price = $('input[name=subtotal_price]').val().replace(/,/g, '');
        total_price = parseInt(total_price) + parseInt(subtotal_price);

        var newInput = '<input type="hidden" name="product_code['+row_counter+']" value="'+product_code+'">'+
                       '<input type="hidden" name="product_name['+row_counter+']" value="'+product_name+'">'+
                       '<input type="hidden" name="type_code['+row_counter+']" value="'+type_code+'">'+
                       '<input type="hidden" name="normal_price['+row_counter+']" value="'+normal_price+'">'+
                       '<input type="hidden" name="discount_rate['+row_counter+']" value="'+discount_rate+'">'+
                       '<input type="hidden" name="discounted_price['+row_counter+']" value="'+discounted_price+'">'+
                       '<input type="hidden" name="qty['+row_counter+']" value="'+qty+'">'+
                       '<input type="hidden" name="subtotal_price['+row_counter+']" value="'+subtotal_price+'">';
        $('.inputWrapper').append(newInput);

        var newRow = '<tr>'+
                    '<td>'+product_code+'</td>'+
                    '<td>'+type_code+'</td>'+
                    '<td>'+product_name+'</td>'+
                    '<td>'+qty+'</td>'+
                    '<td>'+$.number(normal_price, 0)+'</td>'+
                    '<td>'+$.number(discount_rate, 2)+'</td>'+
                    '<td>'+$.number(subtotal_price, 0)+'</td>'+
                    '</tr>';
        $('tbody').append(newRow);
        resetAddItemModal();
        $('input[name=total_price]').val(total_price).change();
        row_counter++;
    });

    function resetAddItemModal()
    {
        $('#addItemModal').modal('hide');
        $('#addItemModal input').val('').change();
        $('#addItemModal input[name=qty]').val(1);
        $('#addItemModal input[name=discount_rate]').val(0);
        $('.floating-select').html('');
    }


    var normal_price;

    function selectProduct(product_code) {
        $('.floating-select').html('');
        $.ajax({
            url: '{{ url('api/product') }}',
            type: 'GET',
            dataType: 'json',
            data: {product_code: product_code},
        })
        .done(function(result) {
            console.log("success");
            $('input[name=product_code]').val(result.data.product_code);
            $('input[name=product_name]').val(result.data.product_name);
            $('input[name=type_code]').val(result.data.type_code).attr('readonly', 'readonly');
            normal_price = result.data.price_capital;
            $('input[name=normal_price]').val(normal_price);
            calculatePrice();
        })
        .fail(function() {
        })
        .always(function(result) {
        });
    }

    $('input[name=discount_rate]').on('change paste keyup', function(){
        calculatePrice();
    });

    $('input[name=qty]').on('change paste keyup', function(){
        calculatePrice();
    });

    function calculatePrice() {
        var discount_rate = $('input[name=discount_rate]').val();
        var discounted_price = parseInt(normal_price - (normal_price * (parseFloat(discount_rate) / 100)));
        var qty = $('input[name=qty]').val();
        var subtotal_price = parseInt(discounted_price * qty);

        $('input[name=discounted_price]').val(discounted_price);
        $('input[name=subtotal_price]').val(subtotal_price);
        $('input[data-type=number]').trigger('change');
    }

    $('input[name=invoice_no]').on('change paste keyup', function(){
        var invoice_no = $(this).val();
        $.ajax({
            url: '{{ url('api/invoice/pembelian') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            $('input[name=invoice_date]').val(result.data.invoice_date).attr('readonly', 'readonly');
            $('input[name=days_expire]').val(result.data.days_expire).attr('readonly', 'readonly');
            $('input[name=description]').val(result.data.description).attr('readonly', 'readonly');
            $('select[name=supplier_code]').val(result.data.supplier_code).change().attr('readonly', 'readonly');
            $('select[name=payment_type]').val(result.data.payment_type).change().attr('readonly', 'readonly');
        })
        .fail(function() {
            $('input[name=invoice_date]').val('').removeAttr('readonly');
            $('input[name=days_expire]').val('').removeAttr('readonly');
            $('input[name=description]').val('').removeAttr('readonly');
            $('select[name=supplier_code]').val('').change().removeAttr('readonly');
            $('select[name=payment_type]').val('').change().removeAttr('readonly');
        })
        .always(function() {
        });
    });

    // create product finder
    var products = JSON.parse('{!! json_encode($products) !!}');
    $('input[name=product_code]').on('change paste keyup', function(){
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
    $('input[name=product_name]').on('change paste keyup', function(){
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

    // create click behaviour
    $('#product_code_list').on('click', 'li', function() {
        selected_product_code = $(this).html();
        $(this).text(selected_product_code);
        selectProduct(selected_product_code);
    });
    $('#product_name_list').on('click', 'li', function() {
        selected_product_code = $(this).data('code');
        $('input[name=product_code]').text(selected_product_code);
        selectProduct(selected_product_code);
    });

    $('#generateInvoiceNo').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: '{{ url('api/invoice/pembelian/generate') }}',
            type: 'GET',
            dataType: 'html',
        })
        .done(function(result) {
            $('input[name=invoice_no]').val(result).change();
        });
    });
</script>
@endsection