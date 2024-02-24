@extends('admin.template')

@section('meta')
<title>List Customer - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/master') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> &nbsp; Master
</a>
<a href="{{ url('admin/master/customer') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/customer.svg') }}"> &nbsp; Customer
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <div class="row">
            <div class="col-3">Kode Customer</div>
            <div class="col">
                <input type="text" name="customer_code" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">Nama Customer</div>
            <div class="col">
                <input type="text" name="customer_name" class="form-control">
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
                    <th>Kode Customer</th>
                    <th>Nama Customer</th>
                    <th>Limit</th>
                    <th>Contact Person</th>
                    <th>Telepon 1</th>
                    <th>Telepon 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <tr>&nbsp;</tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tr>
                <tr>
                    <tr>&nbsp;</tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tr>
                <tr>
                    <tr>&nbsp;</tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tr>
                <tr>
                    <tr>&nbsp;</tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tr>
                <tr>
                    <tr>&nbsp;</tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    var selected_row;

    $('#newButton').on('click', function(){
        window.location.href = '{{ url('admin/master/customer/add') }}';
    });

    $('input').on('change paste keyup', function(){
        searchCustomer();
    });

    function searchCustomer() {
        $.ajax({
            url: '{{ url('api/customer-search') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                customer_code: $('input[name=customer_code]').val(),
                customer_name: $('input[name=customer_name]').val(),
            },
        })
        .done(function(result) {
            console.log(result);
            $('tbody').html('');
            $.each(result.data, function(index, val) {
                var newRow = '<tr data-id="'+val.customer_code+'">'+
                                '<td>'+val.customer_code+'</td>'+
                                '<td>'+val.customer_name+'</td>'+
                                '<td>'+$.number(val.limit, 0)+'</td>'+
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
        window.location.href = "{{ url('admin/master/customer/detail') }}/"+selected_row;
    });

    $('#printButton').on('click', function(){
        window.open('{{ url('admin/print/customer') }}', 'printWindow');
    });
</script>
@endsection