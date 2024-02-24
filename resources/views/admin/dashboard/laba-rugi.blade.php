@extends('admin.template')

@section('meta')
<title>Laba Rugi - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
    <i class="fa-solid fa-boxes"></i> &nbsp; Dashboard
</a>
<a href="{{ url('admin/dashboard/invoice') }}" class="btn btn-danger">
    <i class="fa-solid fa-chart-pie"></i> &nbsp; Laba Rugi
</a>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-2">Periode</div>
    <div class="col">
        @include('shared.select-month', ['name' => 'month_start'])
    </div>
    <div class="col">
        @include('shared.select-month', ['name' => 'month_end'])
    </div>
    <div class="col">
        @include('shared.select-year')
    </div>
    <div class="col-3 text-end">
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
<div class="row mt-3 laporan-head text-start">
    <div class="col">
        <div class="row mt-2">
            <div class="col">PENJUALAN KOTOR</div>
            <div class="col-3">
                <input type="text" data-type="number" name="penjualan_kotor" readonly="readonly" class="form-control text-end">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">MODAL BERSIH</div>
            <div class="col-3">
                <input type="text" data-type="number" name="modal_bersih" readonly="readonly" class="form-control text-end">
            </div>
        </div>
        <div class="row my-2 fw-bold">
            <div class="col">LABA KOTOR</div>
            <div class="col-3">
                <input type="text" data-type="number" name="laba_kotor" disabled="disabled" class="form-control text-end bg-danger text-light">
            </div>
        </div>
    </div>
</div>
<div class="row laporan-head text-start">
    <div class="col">
        <div class="row mt-2">
            <div class="col">KOMISI SALES</div>
            <div class="col-3">
                <input type="text" data-type="number" name="komisi_sales" readonly="readonly" class="form-control text-end">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">BEBAN GAJI</div>
            <div class="col-3">
                <input type="text" data-type="number" name="beban_ops" readonly="readonly" class="form-control text-end">
            </div>
        </div>
        <div class="row my-2 fw-bold">
            <div class="col">TOTAL PENGELUARAN</div>
            <div class="col-3">
                <input type="text" data-type="number" name="total_pengeluaran" disabled="disabled" class="form-control text-end bg-danger text-light">
            </div>
        </div>
    </div>
</div>
<div class="row laporan-head text-start">
    <div class="col">
        <div class="row my-2 fw-bold">
            <div class="col">LABA BERSIH</div>
            <div class="col-3">
                <input type="text" data-type="number" name="laba_bersih" disabled="disabled" class="form-control text-end bg-danger text-light">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('select').on('change', function(){
        updateData();
    });

    function updateData() {
        console.log('aa');
        var year = $('select[name=year]').val();
        var month_start = $('select[name=month_start]').val();
        var month_end = $('select[name=month_end]').val();
        if (year && month_start && month_end) {
            $.ajax({
                url: '{{ url('api/dashboard-laba-rugi') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    year: year,
                    month_start: month_start,
                    month_end: month_end,
                },
            })
            .done(function(result) {
                $('input[name=penjualan_kotor]').val(result.data.penjualan_kotor);
                $('input[name=modal_bersih]').val(result.data.modal_bersih);
                $('input[name=komisi_sales]').val(result.data.komisi_sales);
                $('input[name=beban_ops]').val(result.data.beban_ops);
                var laba_kotor = result.data.penjualan_kotor - result.data.modal_bersih;
                var total_pengeluaran = result.data.komisi_sales + result.data.beban_ops;
                $('input[name=laba_kotor]').val(laba_kotor);
                $('input[name=total_pengeluaran]').val(total_pengeluaran);
                var laba_bersih = laba_kotor - total_pengeluaran;
                $('input[name=laba_bersih]').val(laba_bersih);
                $('input').trigger('change');
            });
        } else {
            console.log('Lengkapi pilihan terlebih dahulu');
            return;
        }

    }
</script>
@endsection