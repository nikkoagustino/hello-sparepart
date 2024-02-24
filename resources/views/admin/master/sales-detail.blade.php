@extends('admin.template')

@section('meta')
<title>Detail Sales - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/sales') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sales.svg') }}"> &nbsp; Sales
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/sales/edit') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-3">
                    Kode Sales
                </div>
                <div class="col-4">
                    <input name="sales_code" readonly="readonly" value="{{ $sales->sales_code }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Nama Sales
                </div>
                <div class="col-7">
                    <input name="sales_name" readonly="readonly" value="{{ $sales->sales_name }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Alamat
                </div>
                <div class="col-9">
                    <textarea name="address" readonly="readonly" rows="3" class="form-control">{{ $sales->address }}</textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    Telepon 1
                </div>
                <div class="col-4">
                    <input name="phone_number_1" readonly="readonly" value="{{ $sales->phone_number_1 }}" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3">
                    Telepon 2
                </div>
                <div class="col-4">
                    <input name="phone_number_2" readonly="readonly" value="{{ $sales->phone_number_2 }}" type="text" class="form-control">
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
        window.location.href='{{ url('admin/master/sales') }}';
    });

    $('#deleteButton').on('click', function(){
        event.preventDefault();
        $("#deleteModal").modal("show");
    });
    function enableDelete() {
        window.location.href = '{{ url('admin/master/sales/delete/'.$sales->sales_code) }}';
    }
    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=sales_code]').attr('readonly', 'readonly');
    }
</script>
@endsection