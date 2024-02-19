@extends('admin.template')
@section('meta')
<title>Akun Admin - {{ config('app.name') }}</title>
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
<div class="row">
    <div class="col-6">
        <h2 class="my-3">Admin</h2>
        <table class="table table-striped selectable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $row)
                <tr data-id="{{ $row->id }}">
                    <td>{{ $row->fullname }}</td>
                    <td>{{ $row->username }}</td>
                    {{-- <td>
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
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
        {{-- <button id="detailButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-arrow-pointer"></i>
            Detail
        </button> --}}
    </div>
</div>
@endsection

@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/account/admin/add') }}';
    });

    $('.selectable').on('click', 'tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');

        if (selected_row) {
            window.location.href='{{ url('admin/account/admin/detail') }}/'+selected_row;
        } else {
            alert('Pilih Admin Terlebih Dahulu');
        }
    });
</script>
@endsection