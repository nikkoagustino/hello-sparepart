@extends('admin.template')

@section('meta')
<title>Detail Supplier - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/supplier') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/supplier.svg') }}"> &nbsp; Supplier
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/supplier/edit') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-3">
                    Kode Supplier
                </div>
                <div class="col-4">
                    <input name="supplier_code" readonly="readonly" value="{{ $supplier->supplier_code }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Nama Supplier
                </div>
                <div class="col-7">
                    <input name="supplier_name" readonly="readonly" value="{{ $supplier->supplier_name }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Alamat
                </div>
                <div class="col-9">
                    <textarea name="address" readonly="readonly" rows="3" class="form-control">{{ $supplier->address }}</textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Telepon 1
                </div>
                <div class="col-4">
                    <input name="phone_number_1" readonly="readonly" value="{{ $supplier->phone_number_1 }}" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Telepon 2
                </div>
                <div class="col-4">
                    <input name="phone_number_2" readonly="readonly" value="{{ $supplier->phone_number_2 }}" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Contact Person
                </div>
                <div class="col-4">
                    <input name="contact_person" readonly="readonly" value="{{ $supplier->contact_person }}" type="text" class="form-control">
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
        window.location.href='{{ url('admin/master/supplier') }}';
    });

    $('#deleteButton').on('click', function(){
        event.preventDefault();
        $("#deleteModal").modal("show");
    });
    function enableDelete() {
        window.location.href = '{{ url('admin/master/supplier/delete/'.$supplier->supplier_code) }}';
    }

    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=supplier_code]').attr('readonly', 'readonly');
    }
</script>
@endsection