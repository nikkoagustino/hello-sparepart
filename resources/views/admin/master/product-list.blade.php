@extends('admin.template')

@section('meta')
<title>List Produk - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/product.svg') }}"> &nbsp; Produk
</a>
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-7">
        <div class="row">
            <div class="col-3">Kode Barang</div>
            <div class="col">
                <input type="text" name="product_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Nama Barang</div>
            <div class="col">
                <input type="text" name="product_name" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus-circle"></i>
            New
        </button>
        <button id="exportButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-file-csv"></i>
            Export
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
<div class="row mt-3">
    <div class="col">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Jenis Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/product/add') }}';
    });

    $('input').on('change paste keyup', function(){
        searchProduct();
    });

    function searchProduct() {
        $.ajax({
            url: '{{ url('api/product-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                product_code: $('input[name=product_code]').val(),
                product_name: $('input[name=product_name]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.product_code+'">'+
                                '<td>'+val.type_code+'</td>'+
                                '<td>'+val.product_code+'</td>'+
                                '<td>'+val.product_name+'</td>'+
                                '<td>'+$.number(val.price_capital, 0)+'</td>'+
                                '<td>'+$.number(val.price_selling, 0)+'</td>'+
                                '<td>'+val.qty_stok+'</td>'+
                                '</tr>';
                $('tbody').append(newRow);
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/master/product/detail') }}/"+selected_row;
    });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/product') }}', 'printWindow');
    });
    $('#exportButton').on('click', function(){
        window.open("{{ url('admin/master/product/export') }}");
     });
</script>
@endsection