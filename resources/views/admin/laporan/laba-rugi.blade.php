@extends('admin.template')

@section('meta')
<title>Laporan - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}"> &nbsp; Laporan
</a>
@endsection
@section('content')
<div class="container-fluid p-3">
    <div class="row">
        <div class="col"><h3>LAPORAN</h3></div>
        <div class="col-1">Periode</div>
        <div class="col-3">
            @include('shared.select-month', ['name' => 'month_start'])
        </div>
        <div class="col-3">
            @include('shared.select-month', ['name' => 'month_end'])
        </div>
        <div class="col-2">
            @include('shared.select-year')
        </div>
    </div>

    @include('shared.tabs-laporan')

    <div class="row mt-5 laporan-head text-start">
        <div class="col p-3">
            <div class="row">
                <div class="col">PENJUALAN KOTOR</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="penjualan_kotor" readonly="readonly" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">MODAL BERSIH</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="modal_bersih" readonly="readonly" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col fw-bold">LABA KOTOR</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="laba_kotor" disabled="disabled" class="form-control bg-danger text-light">
                </div>
            </div>
        </div>
    </div>
    <div class="row laporan-head text-start">
        <div class="col p-3">
            <div class="row my-3">
                <div class="col">KOMISI SALES</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="total_komisi_sales" readonly="readonly" class="form-control">
                </div>
            </div>
            <div id="komisiWrapper"></div>

            <div class="row my-3">
                <div class="col">BEBAN GAJI</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="total_beban_gaji" readonly="readonly" class="form-control">
                </div>
            </div>
            <div id="gajiWrapper"></div>

            <div class="row my-3">
                <div class="col">BEBAN OPERASIONAL</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="total_beban_ops" readonly="readonly" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">INVENTARIS</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="inventaris" readonly="readonly" class="form-control">
                </div>
                <div class="col-5"></div>
            </div>
            <div class="row mt-2">
                <div class="col">REIMBURSE</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="reimburse" readonly="readonly" class="form-control">
                </div>
                <div class="col-5"></div>
            </div>
            <div class="row mt-2">
                <div class="col">PULSA KARYAWAN</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="pulsa" readonly="readonly" class="form-control">
                </div>
                <div class="col-5"></div>
            </div>
            <div class="row mt-2">
                <div class="col">LAINNYA</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="other" readonly="readonly" class="form-control">
                </div>
                <div class="col-5"></div>
            </div>

            <div class="row my-3">
                <div class="col fw-bold">TOTAL PENGELUARAN</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="total_pengeluaran" disabled="disabled" class="form-control bg-danger text-light">
                </div>
            </div>
        </div>
    </div>

    <div class="row laporan-head text-start">
        <div class="col p-3">
            <div class="row">
                <div class="col fw-bold">LABA BERSIH</div>
                <div class="col-3">
                    <input type="text" data-type="number" name="laba_bersih" disabled="disabled" class="form-control bg-danger text-light">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <button id="printButton" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('select[name=month_start]').val(1);
        $('select[name=month_end]').val(12);
        $('select[name=year]').val({{ date('Y') }}).trigger('change');
    });
    $('select').on('change', function(){
        refreshData();
    });

    function refreshData() {
        $('input').val(0);
        var month_start = $('select[name=month_start]').val();
        var month_end = $('select[name=month_end]').val();
        var year = $('select[name=year]').val();
        if (month_end < month_start) {
            alert('Periode mulai harus lebih kecil atau sama dengan periode akhir');
            return;
        }
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
                $('input[name=total_komisi_sales]').val(result.data.komisi_sales);
                $('input[name=total_beban_ops]').val(result.data.beban_ops);
                $('input[name=total_beban_gaji]').val(result.data.gaji);
                var laba_kotor = result.data.penjualan_kotor - result.data.modal_bersih;
                var total_pengeluaran = result.data.komisi_sales + result.data.beban_ops + result.data.gaji;
                $('input[name=laba_kotor]').val(laba_kotor);
                $('input[name=total_pengeluaran]').val(total_pengeluaran);
                var laba_bersih = laba_kotor - total_pengeluaran;
                $('input[name=laba_bersih]').val(laba_bersih);
                $('input').trigger('change');

                // breakdown data
                $('#komisiWrapper').html('');
                $.each(result.breakdown.komisi, function(index, val) {
                    var komisiRow = '<div class="row mt-2">'+
                            '<div class="col">'+val.sales_name+'</div>'+
                            '<div class="col-3">'+
                                '<input type="text" data-type="number" name="komisi[]" readonly="readonly" class="form-control" value="'+$.number(val.komisi, 0)+'">'+
                            '</div><div class="col-5"></div></div>';
                    $('#komisiWrapper').append(komisiRow);
                });

                $('#gajiWrapper').html('');
                $.each(result.breakdown.gaji, function(index, val) {
                    var gajiRow = '<div class="row mt-2">'+
                            '<div class="col">'+val.sales_name+'</div>'+
                            '<div class="col-3">'+
                                '<input type="text" data-type="number" name="beban_gaji[]" readonly="readonly" class="form-control" value="'+$.number(val.gaji, 0)+'">'+
                            '</div><div class="col-5"></div></div>';
                    $('#gajiWrapper').append(gajiRow);
                });

                $('input[name=pulsa]').val($.number(result.breakdown.beban_ops.pulsa,0));
                $('input[name=reimburse]').val($.number(result.breakdown.beban_ops.reimburse,0));
                $('input[name=inventaris]').val($.number(result.breakdown.beban_ops.inventaris,0));
                $('input[name=other]').val($.number(result.breakdown.beban_ops.other,0));
            });
        }
    }

    $('#printButton').on('click', function(){
        var month_start = $('select[name=month_start]').val();
        var month_end = $('select[name=month_end]').val();
        var year = $('select[name=year]').val();
        const params = new URLSearchParams({
            year: year,
            month_start: month_start,
            month_end: month_end,
        });
        window.open('{{ url('admin/print/laporan-laba-rugi') }}?'+params, 'printWindow');
    });
</script>
@endsection