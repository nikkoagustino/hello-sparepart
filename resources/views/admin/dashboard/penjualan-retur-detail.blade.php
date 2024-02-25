@extends('admin.template')

@section('meta')
<title>Retur Penjualan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')

<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <i class="fa-solid fa-boxes"></i> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-store"></i> &nbsp; Invoice
</a>
<a href="{{ url('admin/dashboard/invoice/penjualan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/icon/penjualan.svg') }}" alt=""> &nbsp; Penjualan
</a>
@endsection

@section('content')
<div class="row mt-3" id="returWrapper">
    <div class="col-12">
        <div class="breadcrumb">
            <div class="row pt-3">
                <div class="col">
                    <a href="{{ url()->current() }}" class="btn btn-danger">
                        <img src="{{ url('assets/img/svg/retur.svg') }}"> &nbsp; Retur
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-striped print table-condensed selectable" id="returItemsTable">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga /pcs</th>
                    <th>Disc (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $retur_data->product_code }}</td>
                    <td>{{ $retur_data->type_code }}</td>
                    <td>{{ $retur_data->product_name }}</td>
                    <td>{{ number_format($retur_data->qty, 0) }}</td>
                    <td>{{ number_format($retur_data->normal_price, 0) }}</td>
                    <td>{{ number_format($retur_data->discount_rate, 2) }}</td>
                    <td>{{ number_format($retur_data->subtotal_price, 0) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col">
        <button id="deleteButton" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger btn-icon-lg">
            <i class="fa-solid fa-trash"></i>
            Delete
        </button>
    </div>
    <div class="col-1">Total</div>
    <div class="col-3">
        <input type="text" data-type="number" readonly="readonly" class="form-control bg-khaki" value="{{ number_format($retur_data->subtotal_price, 0) }}" name="total_returned_price">
    </div>
</div>
@endsection

@section('script')
<script>
    function enableDelete(){
        window.location.href = '{{ url('admin/dashboard/invoice/penjualan/retur/delete') }}?id={{ request()->id }}';
    }
</script>
@endsection