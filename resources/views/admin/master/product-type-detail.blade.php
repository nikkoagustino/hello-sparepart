@extends('admin.template')

@section('meta')
<title>Detail Jenis Barang - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product-type') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/jenis-barang.svg') }}"> &nbsp; Jenis Barang
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/product-type/edit') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Kode Barang
                </div>
                <div class="col-8">
                    <input name="type_code" readonly="readonly" value="{{ $product_type->type_code }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Jenis Barang
                </div>
                <div class="col-8">
                    <input name="type_name" readonly="readonly" value="{{ $product_type->type_name }}" required="required" type="text" class="form-control">
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
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col mt-2">
            <button id="listButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-file-lines"></i>
                List
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
    $('#listButton').on('click', function(){
        window.location.href='{{ url('admin/master/product-type') }}';
    });

    $('#deleteButton').on('click', function(){
        $('#deleteAction').attr('href', '{{ url('admin/master/product-type/delete/'.$product_type->type_code) }}');
        $("#deleteModal").modal("show");
    });

    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=type_code]').attr('readonly', 'readonly');
    }
</script>
@endsection