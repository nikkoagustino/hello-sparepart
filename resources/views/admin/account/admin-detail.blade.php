@extends('admin.template')
@section('meta')
<title>Tambah Admin - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
<a href="{{ url('admin/account/admin') }}" class="btn btn-danger">
    <i class="fa-solid fa-user-secret"></i> &nbsp; Admin
</a>
@endsection
@section('content')
<form action="{{ url('admin/account/admin/edit') }}" method="POST">
@csrf
<input type="hidden" name="id" value="{{ $admin->id }}">
<div class="row">
    <div class="col-8">
        <div class="row mb-4">
            <div class="col-12">
                <h2>NEW ADMIN</h2>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Nama
            </div>
            <div class="col">
                <input type="text" name="fullname" value="{{ $admin->fullname }}" readonly="readonly" placeholder="Nama" required="required" class="form-control">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Username
            </div>
            <div class="col">
                <input type="text" required="required" value="{{ $admin->username }}" readonly="readonly" placeholder="Username" name="username" class="form-control" minlength="6">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Password
            </div>
            <div class="col">
                <input type="password" value="" readonly="readonly" placeholder="**********" name="password" class="form-control mb-2" minlength="8">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Confirm Password
            </div>
            <div class="col">
                <input type="password" value="" readonly="readonly" placeholder="**********" name="confirm_password" class="form-control mb-2" minlength="8">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Master PIN
            </div>
            <div class="col">
                <input type="text"  value="" readonly="readonly" name="master_pin" placeholder="******" class="form-control mb-2" minlength="6" maxlength="6">
            </div>
        </div>
    </div>

    <div class="col text-end">
        <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-save"></i>
            Save
        </button>
        <button id="editButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-pencil"></i>
            Edit
        </button>
        <button id="deleteButton" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
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
    function enableEdit() {
        $('#deleteButton').hide();
        $('input').removeAttr('readonly');
    }
</script>
@endsection