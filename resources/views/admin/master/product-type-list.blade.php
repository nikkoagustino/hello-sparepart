@extends('admin.template')

@section('meta')
<title>List Jenis Barang - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/product-type') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/jenis-barang.svg') }}"> &nbsp; Jenis Barang
</a>
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">Kode Jenis</div>
            <div class="col">
                <input type="text" name="type_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Jenis Barang</div>
            <div class="col">
                <input type="text" name="type_name" class="form-control">
            </div>
        </div>
    </div>
    <div class="col text-end">
        <button id="newButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-plus-circle"></i>
            New
        </button>
        <button id="printButton" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-print"></i>
            Print
        </button>
        <button type="back" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-rotate-left"></i>
            Back
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col-8">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        searchtype();
    });
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/product-type/add') }}';
    });


    $('input').on('change paste keyup', function(){
        searchtype();
    });

    function searchtype() {
        $.ajax({
            url: '{{ url('api/product-type-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                type_code: $('input[name=type_code]').val(),
                type_name: $('input[name=type_name]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.type_code+'">'+
                                '<td>'+val.type_code+'</td>'+
                                '<td>'+val.type_name+'</td>'+
                                '</tr>';
                $('tbody').append(newRow);
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/master/product-type/detail') }}/"+selected_row;
    });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/product-type') }}', 'printWindow');
    })
</script>
@endsection