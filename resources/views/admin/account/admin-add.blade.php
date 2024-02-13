@extends('admin.template')
@section('meta')
<title>Tambah Admin - {{ env('APP_NAME') }}</title>
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
<form action="{{ url('admin/account/admin/add') }}" method="POST">
@csrf
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
                <input type="text" name="fullname" placeholder="Nama" required="required" class="form-control">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Username
            </div>
            <div class="col">
                <input type="text" required="required" placeholder="Username" name="username" class="form-control" minlength="6">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Password
            </div>
            <div class="col">
                <input type="password" required="required" placeholder="Password" name="password" class="form-control mb-2" minlength="8">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Confirm Password
            </div>
            <div class="col">
                <input type="password" required="required" placeholder="Confirm Password" name="confirm_password" class="form-control mb-2" minlength="8">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Master PIN
            </div>
            <div class="col">
                <input type="text" required="required" name="master_pin" placeholder="6 digit Master PIN" class="form-control mb-2" minlength="6" maxlength="6">
            </div>
        </div>
    </div>

    <div class="col text-end">
        <button class="btn btn-danger btn-icon-lg" type="submit"><i class="fa-solid fa-save"></i> Simpan</button>
    </div>
</div>
</form>

@endsection