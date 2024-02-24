@extends('admin.template')

@section('meta')
<title>Detail Sales - {{ config('app.name') }}</title>
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
<form action="{{ url('admin/master/product/edit') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-3">
                    Kode Produk
                </div>
                <div class="col-6">
                    <input name="product_code" readonly="readonly" value="{{ $product->product_code }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Nama Produk
                </div>
                <div class="col-6">
                    <input name="product_name" readonly="readonly" value="{{ $product->product_name }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Harga Modal
                </div>
                <div class="col-3">
                    <input name="price_capital" value="{{ number_format($product->price_capital, 0) }}" required="required" readonly="readonly" type="text" data-type="number" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Harga Jual
                </div>
                <div class="col-3">
                    <input name="price_selling" value="{{ number_format($product->price_selling, 0) }}" required="required" readonly="readonly" type="text" data-type="number" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Jenis Barang
                </div>
                <div class="col-3">
                    <select name="type_code" required="required" readonly="readonly" class="form-select form-control">
                        @foreach ($product_types as $row)
                        <option {{ ($row->type_code == $product->type_code) ? 'selected="selected"' : ''; }} value="{{ $row->type_code }}">{{ $row->type_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select name="type_code_name" required="required" readonly="readonly" class="form-select form-control">
                        @foreach ($product_types as $row)
                        <option {{ ($row->type_code == $product->type_code) ? 'selected="selected"' : ''; }} value="{{ $row->type_code }}">{{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Qty
                </div>
                <div class="col-3">
                    <input name="qty_stok" value="{{ number_format($product->qty_stok, 0) }}" required="required" readonly="readonly" type="text" data-type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-4 text-end">
            <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button>
            <button id="editButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-pencil"></i>
                Edit
            </button>
            <button id="deleteButton" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-trash"></i>
                Delete
            </button>
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    $('#listButton').on('click', function(){
        window.location.href='{{ url('admin/master/product') }}';
    });

    $('#deleteButton').on('click', function(){
        event.preventDefault();
        $("#deleteModal").modal("show");
    });
    function enableDelete() {
        window.location.href = '{{ url('admin/master/product/delete/'.$product->product_code) }}';
    }
    $('#txButton').on('click', function(){
        window.location.href='{{ url('admin/master/product/transaksi/'.$product->product_code) }}';
    });

    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=product_code]').attr('readonly', 'readonly');
    }
</script>
@endsection