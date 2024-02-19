@extends('admin.template')

@section('meta')
<title>Detail V-Belt - {{ config('app.name') }}</title>
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
<form action="{{ url('admin/master/vbelt/edit') }}" method="POST">
    @csrf
    <input type="hidden" name="id" readonly="readonly" value="{{ $vbelt->id }}">
    <div class="row mt-5">
        <div class="col-8">
            <div class="row mb-2">
                <div class="col-4">
                    Jenis Barang
                </div>
                <div class="col-8">
                    <select name="type_code" required="required" readonly="readonly" class="form-select form-control">
                        @foreach ($product_types as $row)
                        <option {{ ($row->type_code == $vbelt->type_code) ? 'selected="selected"' : ''; }} value="{{ $row->type_code }}">{{ $row->type_code }} - {{ $row->type_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Model
                </div>
                <div class="col-8">
                    <input name="model" required="required" type="text" class="form-control" readonly="readonly" value="{{ $vbelt->model }}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Ukuran
                </div>
                <div class="col-4">
                    <input type="number" name="size_min" required="required" class="form-control" readonly="readonly" value="{{ $vbelt->size_min }}">
                </div>
                <div class="col-4">
                    Min
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                </div>
                <div class="col-4">
                    <input type="number" name="size_max" required="required" class="form-control" readonly="readonly" value="{{ $vbelt->size_max }}">
                </div>
                <div class="col-4">
                    Max
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    Harga
                </div>
                <div class="col-8">
                    <input data-type="number" name="price" required="required" type="text" class="form-control" readonly="readonly" value="{{ number_format($vbelt->price, 0) }}">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    Discount
                </div>
                <div class="col-7">
                    <input name="discount" type="number" class="form-control" step="0.01" readonly="readonly" value="{{ number_format($vbelt->discount, 2) }}">
                </div>
                <div class="col-1">%</div>
            </div>

            <div class="row mb-2">
                <div class="col-4">
                    INCH/PCS
                </div>
                <div class="col-8">
                    <input name="price_unit" required="required" type="text" class="form-control" readonly="readonly" value="{{ $vbelt->price_unit }}">
                </div>
            </div>

        </div>


        <div class="col-4 text-end">
            <button id="saveButton" style="display: none" type="submit" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button>
            <button id="editButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-pencil"></i>
                Edit
            </button>
            <button type="back" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-rotate-left"></i>
                Back
            </button>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col mt-2">
            <button id="listButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-file-lines"></i>
                List
            </button>
            <button id="txButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Transaksi
            </button>
            <button id="deleteButton" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-trash"></i>
                Delete
            </button>
        </div>
    </div>
@endsection


@section('script')
<script>
    $('#listButton').on('click', function(){
        window.location.href='{{ url('admin/master/vbelt') }}';
    });

    $('#deleteButton').on('click', function(){
        $('#deleteAction').attr('href', '{{ url('admin/master/vbelt/delete/'.$vbelt->id) }}');
        $("#deleteModal").modal("show");
    });

    function enableEdit() {
        $('input').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        $('select').removeAttr('readonly');
        $('input[name=id]').attr('readonly', 'readonly');
    }
</script>
@endsection