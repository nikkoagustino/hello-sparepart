@extends('admin.template')

@section('meta')
<title>List Supplier - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/supplier') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/supplier.svg') }}"> &nbsp; Supplier
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">Kode Supplier</div>
            <div class="col">
                <input type="text" name="supplier_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Nama Supplier</div>
            <div class="col">
                <input type="text" name="supplier_name" class="form-control">
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
    <div class="col">
        <table class="table table-striped print table-condensed selectable">
            <thead>
                <tr>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Contact Person</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/supplier/add') }}';
    });


    $('input').on('change paste keyup', function(){
        searchsupplier();
    });

    function searchsupplier() {
        $.ajax({
            url: '{{ url('api/supplier-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                supplier_code: $('input[name=supplier_code]').val(),
                supplier_name: $('input[name=supplier_name]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.supplier_code+'">'+
                                '<td>'+val.supplier_code+'</td>'+
                                '<td>'+val.supplier_name+'</td>'+
                                '<td>'+val.contact_person+'</td>'+
                                '<td>'+val.phone_number_1+'</td>'+
                                '<td>'+val.phone_number_2+'</td>'+
                                '</tr>';
                $('tbody').append(newRow);
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/master/supplier/detail') }}/"+selected_row;
    });
    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/supplier') }}', 'printWindow');
    });
</script>
@endsection