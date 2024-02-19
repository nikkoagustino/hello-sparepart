@extends('admin.template')

@section('meta')
<title>Surat Jalan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <i class="fa-solid fa-boxes"></i> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/surat-jalan') }}" class="btn btn-danger">
    <i class="fa-solid fa-motorcycle"></i> &nbsp; Surat Jalan
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-9">
        <div class="row mt-2">
            <div class="col-3">
                No. Invoice
            </div>
            <div class="col-6">
                <input type="text" name="invoice_no" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Tgl. Pengiriman
            </div>
            <div class="col-6">
                <input type="date" name="tgl_kirim" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Tgl. Invoice
            </div>
            <div class="col-4">
                <input type="date" name="invoice_date" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Kode Supplier
            </div>
            <div class="col-4">
                <input type="text" name="customer_code" readonly="readonly" class="form-control">
            </div>
            <div class="col">
                <input type="text" name="customer_name" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Alamat
            </div>
            <div class="col">
                <textarea name="customer_address" class="form-control" readonly="readonly" rows="3" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Jatuh Tempo
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="days_expire" readonly="readonly">
            </div>
            <div class="col-2">
                Hari
            </div>
            <div class="col-1">
                Ket
            </div>
            <div class="col">
                <input type="text" name="description" readonly="readonly" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                Status
            </div>
            <div class="col-4">
                <input type="text" name="payment_type" readonly="readonly" class="form-control">
            </div>
        </div>

    </div>

    <div class="col text-end">
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
<div class="row mt-5">
    <table class="table table-striped selectable">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    $('input[name=invoice_no]').on('change paste keyup', function(){
        $.ajax({
            url: '{{ url('api/invoice/penjualan') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: $(this).val()},
        })
        .done(function(result) {
            console.log(result);
            $('input[name=invoice_date]').val(result.data.invoice_date);
            $('input[name=customer_code]').val(result.data.customer_code);
            $('input[name=customer_name]').val(result.data.customer_name);
            $('textarea[name=customer_address]').text(result.data.customer_address);
            $('input[name=days_expire]').val(result.data.days_expire);
            $('input[name=description]').val(result.data.description);
            $('input[name=payment_type]').val(result.data.payment_type);
            fetchItem();
        });
        
    });

    function fetchItem()
    {
        $.ajax({
            url: '{{ url('api/invoice/penjualan/items') }}',
            type: 'GET',
            dataType: 'json',
            data: {invoice_no: $('input[name=invoice_no]').val()},
        })
        .done(function(result) {
            var rows = '';
            $.each(result.data, function(index, val) {
                rows += '<tr><td>'+val.product_code+'</td>';
                rows += '<td>'+val.type_code+'</td>';
                rows += '<td>'+val.product_name+'</td>';
                rows += '<td>'+val.qty+'</td></tr>';
            });
            $('tbody').html(rows);
        });
        
    }

    $('#printButton').on('click', function(){
        var invoice_no = $('input[name=invoice_no]').val();
        var tgl_kirim = $('input[name=tgl_kirim]').val();
        
        if (!invoice_no) {
            alert('Nomor invoice belum diisi');
            return;
        }
        if (!tgl_kirim) {
            alert('Belum menentukan tanggal kirim');
            return;
        }
        var params = {
            invoice_no: invoice_no,
            tgl_kirim: tgl_kirim,
        }
        window.open('{{ url('admin/print/surat_jalan') }}?' + $.param(params), 'printWindow');
    });
</script>
@endsection