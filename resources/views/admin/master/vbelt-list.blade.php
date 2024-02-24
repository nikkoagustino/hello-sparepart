@extends('admin.template')

@section('meta')
<title>List V-Belt - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/vbelt') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/vbelt.svg') }}"> &nbsp; V-Belt
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">Jenis Barang</div>
            <div class="col">
                <input type="text" name="type_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Model</div>
            <div class="col">
                <input type="text" name="model" class="form-control">
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
                    <th>Jenis</th>
                    <th>Model</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>INCH/PCS</th>
                    <th>Disc (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
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
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
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
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
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
        window.location.href = '{{ url('admin/master/vbelt/add') }}';
    });
    
    $('input').on('change paste keyup', function(){
        searchvbelt();
    });

    function searchvbelt() {
        $.ajax({
            url: '{{ url('api/vbelt-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                type_code: $('input[name=type_code]').val(),
                model: $('input[name=model]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.id+'">'+
                                '<td>'+val.type_code+'</td>'+
                                '<td>'+val.model+'</td>'+
                                '<td>'+val.size_min+' s/d '+val.size_max+'</td>'+
                                '<td>'+$.number(val.price, 0)+'</td>'+
                                '<td>'+val.price_unit+'</td>'+
                                '<td>'+$.number(val.discount, 2)+'</td>'+
                                '</tr>';
                $('tbody').append(newRow);
            });
        });
    }

    $('body').on('click', '.selectable tbody tr', function() {
        var selected_row = $(this).data('id');
        $('tr').removeClass('selected');
        $('tr[data-id="'+selected_row+'"]').addClass('selected');
        window.location.href = "{{ url('admin/master/vbelt/detail') }}/"+selected_row;
    });
    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/vbelt') }}', 'printWindow');
    });
</script>
@endsection