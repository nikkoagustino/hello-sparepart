@extends('admin.template')
@section('meta')
<title>Akun - {{ env('APP_NAME') }}</title>
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
                    <td>
                        @if ($row->two_fa_secret)
                        <a class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus 2FA" href="{{ url('admin/account/2fa-remove') }}">
                            <i class="fa-solid fa-key"></i>
                        </a>
                        @endif
                        @if ($row->username != Session::get('userdata')->username)
                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus Account" onclick='deleteAdmin("{{ $row->username }}")'>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col">
        <form action="{{ url('admin/account/admin') }}" method="POST">
            @csrf
            <h2>Tambah Admin Baru</h2>
            <span>Username</span>
            <input type="text" required="required" placeholder="Username" name="username" class="form-control mb-2" minlength="6">
            <span>Email</span>
            <input type="email" required="required" placeholder="alamat@email.com" name="email" class="form-control mb-2">
            <span>Password</span>
            <input type="password" required="required" placeholder="Password" name="password" class="form-control mb-2" minlength="8">
            <input type="password" required="required" placeholder="Confirm Password" name="confirm_password" class="form-control mb-2" minlength="8">
            <span>Master PIN</span>
            <input type="text" required="required" name="master_pin" placeholder="6 digit Master PIN" class="form-control mb-2" minlength="6" maxlength="6">
            <button class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    function deleteAdmin(username) {
        if (window.confirm('Yakin menghapus admin '+username+'?')) {
            window.location.href='{{ url('admin/account/admin/delete') }}/'+username;
        }
    }
</script>
@endsection