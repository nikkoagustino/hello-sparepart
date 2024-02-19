@extends('admin/template')
@section('meta')
<title>Laba Rugi - {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
<a href="{{ url('admin/laporan') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}"> &nbsp; Laporan
</a>
<a href="{{ url('admin/laporan/laba-rugi') }}" class="btn btn-danger">
    <img src="{{ url('assets/img/svg/laba-rugi.svg') }}"> &nbsp; Laba Rugi
</a>
@endsection
@section('content')
    <div class="row mt-5">
        <div class="col-1">
            Periode
        </div>
        <div class="col-2">
            <input type="number" name="year" step="1" min="2000" max="2200" value="{{ date('Y') }}" class="form-control">
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
    <div class="row p-3 laporan-head text-start">
        <div class="col col-print-12">
            <table class="table table-striped print">
                <thead>
                    <tr>
                        <th>BULAN</th>
                        <th>LABA KOTOR</th>
                        <th>PENGELUARAN</th>
                        <th>LABA</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        refreshData();
    });
    $('input').on('change paste keyup', function(){
        refreshData();
    });

    function refreshData() {
        var year = $('input[name=year]').val();
        $.ajax({
            url: '{{ url('api/laporan-tahunan') }}?year='+year,
            type: 'GET',
            dataType: 'json'
        })
        .done(function(result) {
            $('tbody').html('');
            $.each(result.reports, function(index, val) {
                var nDate = new Date();
                nDate.setMonth(val.month);
                var monthName = nDate.toLocaleString('id-ID', { month: 'long' });
                var row = '<tr><td>'+monthName.toUpperCase()+'</td><td>'+$.number(val.laba_kotor, 0)+'</td><td>'+$.number(val.total_pengeluaran, 0)+'</td><td>'+$.number(val.laba_bersih, 0)+'</td></tr>';
                $('tbody').append(row);
            });
        });
    }

    $('#printButton').on('click', function(){
        var year = $('input[name=year]').val();
        window.open('{{ url('admin/print/laba-rugi-tahun') }}/'+year, 'printWindow');
    });
</script>
@endsection