@extends('admin.template')

@section('meta')
<title>Buat Invoice - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/penjualan') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Penjualan
</a>
<a href="{{ url('admin/penjualan/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-invoice-dollar"></i> &nbsp; Invoice
</a>
<a href="{{ url('admin/penjualan/invoice/new') }}" class="btn btn-danger">
    <i class="fa-solid fa-file-circle-plus"></i> &nbsp; Invoice Baru
</a>
@endsection

@section('content')
<form action="{{ url('admin/penjualan/invoice/new') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    No. Invoice
                </div>
                <div class="col-8">
                    <div class="input-group">
                        <button class="btn btn-danger btn-form" type="button" id="generateInvoiceNo">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <input name="invoice_no" required="required" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Tanggal Invoice
                </div>
                <div class="col-8">
                    <input name="invoice_date" required="required" type="date" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Kode Customer
                </div>
                <div class="col-8">
                    <select name="customer_code" required="required" class="form-select form-control">
                        <option value="" selected="selected" disabled="disabled">Pilih Customer...</option>
                        @foreach ($customers as $row)
                        <option value="{{ $row->customer_code }}">{{ $row->customer_code }} - {{ $row->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Kode Sales
                </div>
                <div class="col-8">
                    <select name="sales_code" required="required" class="form-select form-control">
                        <option value="" selected="selected" disabled="disabled">Pilih Sales...</option>
                        @foreach ($sales as $row)
                        <option value="{{ $row->sales_code }}">{{ $row->sales_code }} - {{ $row->sales_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Jatuh Tempo
                </div>
                <div class="col-2">
                    <input name="days_expire" required="required" type="number" step="1" class="form-control">
                </div>
                <div class="col-4">Hari</div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Keterangan
                </div>
                <div class="col-8">
                    <input name="description" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Status
                </div>
                <div class="col-8">
                    <select name="payment_type" required="required" class="form-select form-control">
                        <option value="" disabled="disabled" selected="selected">Pilih Status...</option>
                        <option value="TUNAI">TUNAI</option>
                        <option value="KREDIT">KREDIT</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-4 text-end">
            <button type="submit" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button>
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-2">Kode Barang</div>
        <div class="col-3 position-relative">
            <input type="text" name="product_code" class="form-control">
            <ul class="floating-select" id="product_code_list"></ul>
        </div>
        <div class="col-2">
            <input type="text" name="type_code" readonly="readonly" class="form-control">
        </div>
        <div class="col-5 position-relative">
            <input type="text" name="product_name" class="form-control">
            <ul class="floating-select" id="product_name_list"></ul>
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2">Harga</div>
        <div class="col-3">
            <input type="text" data-type="number" name="normal_price" class="form-control">
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2">Discount</div>
        <div class="col-3">
            <input type="number" step="0.01" value="0" name="discount_rate" class="form-control">
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2">Harga Discount</div>
        <div class="col-3">
            <input type="text" data-type="number" name="discounted_price" readonly="readonly" class="form-control">
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2">Qty</div>
        <div class="col-3">
            <input type="number" name="qty" value="1" class="form-control">
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2">Total</div>
        <div class="col-3">
            <input type="text" data-type="number" name="subtotal_price" readonly="readonly" class="form-control">
        </div>
    </div>

</form>
@endsection

@section('script')
<script>
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
            normal_price = result.data.price_selling;
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
            url: '{{ url('api/invoice/penjualan') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: invoice_no},
        })
        .done(function(result) {
            $('input[name=invoice_date]').val(result.data.invoice_date).attr('readonly', 'readonly');
            $('input[name=days_expire]').val(result.data.days_expire).attr('readonly', 'readonly');
            $('input[name=description]').val(result.data.description).attr('readonly', 'readonly');
            $('select[name=customer_code]').val(result.data.customer_code).change().attr('readonly', 'readonly');
            $('select[name=sales_code]').val(result.data.sales_code).change().attr('readonly', 'readonly');
            $('select[name=payment_type]').val(result.data.payment_type).change().attr('readonly', 'readonly');
        })
        .fail(function() {
            $('input[name=invoice_date]').val('').removeAttr('readonly');
            $('input[name=days_expire]').val('').removeAttr('readonly');
            $('input[name=description]').val('').removeAttr('readonly');
            $('select[name=customer_code]').val('').change().removeAttr('readonly');
            $('select[name=sales_code]').val('').change().removeAttr('readonly');
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
            url: '{{ url('api/invoice/penjualan/generate') }}',
            type: 'GET',
            dataType: 'html',
        })
        .done(function(result) {
            $('input[name=invoice_no]').val(result).change();
        });
    });
</script>
@endsection