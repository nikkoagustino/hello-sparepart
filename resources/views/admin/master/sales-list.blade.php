@extends('admin.template')

@section('meta')
<title>List Sales - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/sales') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sales.svg') }}"> &nbsp; Sales
</a>
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">Kode Sales</div>
            <div class="col">
                <input type="text" name="sales_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Nama Sales</div>
            <div class="col">
                <input type="text" name="sales_name" class="form-control">
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
                    <th>Kode Sales</th>
                    <th>Nama Sales</th>
                    <th>Alamat</th>
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
        window.location.href = '{{ url('admin/master/sales/add') }}';
    });

    $('input').on('change paste keyup', function(){
        searchSales();
    });

    function searchSales() {
        $.ajax({
            url: '{{ url('api/sales-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                sales_code: $('input[name=sales_code]').val(),
                sales_name: $('input[name=sales_name]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.sales_code+'">'+
                                '<td>'+val.sales_code+'</td>'+
                                '<td>'+val.sales_name+'</td>'+
                                '<td>'+val.address+'</td>'+
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
        window.location.href = "{{ url('admin/master/sales/detail') }}/"+selected_row;
    });
    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/sales') }}', 'printWindow');
    })
</script>
@endsection