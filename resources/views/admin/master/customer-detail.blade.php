@extends('admin.template')

@section('meta')
<title>Detail Customer - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/customer') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/customer.svg') }}"> &nbsp; Customer
</a>
@endsection

@section('content')
<form action="{{ url('admin/master/customer/edit') }}" method="POST">
    @csrf
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Kode Customer
                </div>
                <div class="col-5">
                    <input name="customer_code" readonly="readonly" value="{{ $customer->customer_code }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Nama Customer
                </div>
                <div class="col-7">
                    <input name="customer_name" readonly="readonly" value="{{ $customer->customer_name }}" required="required" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Alamat
                </div>
                <div class="col-8">
                    <textarea name="address" readonly="readonly" rows="3" class="form-control">{{ $customer->address }}</textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Telepon 1
                </div>
                <div class="col-5">
                    <input name="phone_number_1" readonly="readonly" value="{{ $customer->phone_number_1 }}" required="required" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Telepon 2
                </div>
                <div class="col-5">
                    <input name="phone_number_2" readonly="readonly" value="{{ $customer->phone_number_2 }}" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Contact Person
                </div>
                <div class="col-5">
                    <input name="contact_person" readonly="readonly" value="{{ $customer->contact_person }}" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Limit
                </div>
                <div class="col-5">
                    <input name="limit" required="required" readonly="readonly" value="{{ $customer->limit }}" type="text" data-type="number" class="form-control">
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
            <button id="deleteButton" class="btn btn-danger btn-icon-lg">
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
        window.location.href='{{ url('admin/master/customer') }}';
    });
    $('#deleteButton').on('click', function(){
        event.preventDefault();
        $("#deleteModal").modal("show");
    });
    function enableDelete() {
        window.location.href = '{{ url('admin/master/customer/delete/'.$customer->customer_code) }}';
    }
    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=customer_code]').attr('readonly', 'readonly');
    }
</script>
@endsection