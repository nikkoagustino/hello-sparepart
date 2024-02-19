@extends('admin.template')
@section('meta')
<title>Akun - {{ config('app.name') }}</title>
@endsection
@section('content')
<div class="row">
    <div class="col">
        <h2>List Admin</h2>
        <table class="table table-striped print">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $row)
                <tr>
                    <td>{{ $row->username }}</td>
                    <td>{{ $row->email }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col">
        <form action="{{ url('admin/account') }}" method="POST">
            @csrf
            <h2>Tambah Admin Baru</h2>
            <span>Username</span>
            <input type="text" placeholder="Username" name="username" class="form-control mb-2" minlength="6">
            <span>Email</span>
            <input type="email" placeholder="alamat@email.com" name="email" class="form-control mb-2">
            <span>Password</span>
            <input type="password" placeholder="Password" name="password" class="form-control mb-2" minlength="8">
            <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control mb-2" minlength="8">
            <button class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection