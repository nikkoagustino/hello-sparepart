@extends('admin.template')

@section('meta')
<title>Account - {{ env('APP_NAME') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/account') }}" class="btn btn-danger">
    <i class="fa-solid fa-users"></i> &nbsp; Account
</a>
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-9 mx-5 px-5">
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-4">
                <a href="{{ url('admin/account/sales') }}" class="btn btn-selection btn-purple">
                    <span class="display-1">
                        <i class="fa-solid fa-headset"></i>
                    </span>
                    Sales
                </a>
            </div>
            <div class="col-4">
                <a href="{{ url('admin/account/admin') }}" class="btn btn-selection btn-pink">
                    <span class="display-1">
                        <i class="fa-solid fa-user-secret"></i>
                    </span>
                    Admin
                </a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
@endsection