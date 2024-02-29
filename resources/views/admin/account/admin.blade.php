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
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </button>
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