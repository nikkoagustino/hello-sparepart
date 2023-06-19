@extends('admin/template')
@section('meta')
<title>Laba Rugi - {{ env('APP_NAME') }}</title>
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
{{-- <form action="{{ url('admin/laporan/laba-rugi') }}" method="post"> --}}
    {{-- @csrf --}}
    <div class="row mt-5">
        <div class="col-1">
            Periode
        </div>
        <div class="col-3">
            <select name="month" class="form-select form-control">
                <option value="01">JANUARI</option>
                <option value="02">FEBRUARI</option>
                <option value="03">MARET</option>
                <option value="04">APRIL</option>
                <option value="05">MEI</option>
                <option value="06">JUNI</option>
                <option value="07">JULI</option>
                <option value="08">AGUSTUS</option>
                <option value="09">SEPTEMBER</option>
                <option value="10">OKTOBER</option>
                <option value="11">NOVEMBER</option>
                <option value="12">DESEMBER</option>
            </select>
        </div>
        <div class="col-2">
            <select name="year" class="form-select form-control">
                @php
                $year = date('Y');
                while ($year > 2010):
                @endphp
                <option value="{{ $year }}">{{ $year }}</option>
                @php
                $year--;
                endwhile;
                @endphp
            </select>
        </div>
        <div class="col text-end">
            {{-- <button id="saveButton" type="submit" class="btn btn-danger btn-icon-lg">
                <i class="fa-solid fa-save"></i>
                Save
            </button> --}}
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
    <div class="row p-3 laporan-head text-start print">
        
        <div class="row">
            <div class="col-8 pt-2">
                PENJUALAN KOTOR
            </div>
            <div class="col-4">
                <input type="text" data-type="number" readonly="readonly" name="penjualan_kotor" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-8 pt-2">
                MODAL BERSIH
            </div>
            <div class="col-4"> 
                <input type="text" data-type="number" readonly="readonly" name="modal_bersih" class="form-control">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-8 pt-2">
                LABA KOTOR
            </div>
            <div class="col-4">
                <input type="text" data-type="number" readonly="readonly" name="laba_kotor" class="form-control">
            </div>
        </div>

    </div>
    <div class="row mt-0 p-3 laporan-head text-start">
        
        <div class="row">
            <div class="col-8 pt-2">
                KOMISI SALES
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" readonly="readonly" name="komisi_total" class="form-control">
            </div>
        </div>
        @foreach ($sales as $row)
        <div class="row mt-1">
            <div class="col-4 pt-2">
                {{ $row->sales_name }}
            </div>
            <div class="col-4">
                <input type="text" value='0' readonly="readonly" data-type="number" name="komisi[{{$row->sales_code}}]" class="form-control komisi_sales">
            </div>
        </div>
        @endforeach
        <div class="row mt-5">
            <div class="col-8 pt-2">
                BEBAN GAJI
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" readonly="readonly" name="gaji_total" class="form-control">
            </div>
        </div>
        @foreach ($sales as $row)
        <div class="row mt-1">
            <div class="col-4 pt-2">
                {{ $row->sales_name }}
            </div>
            <div class="col-4">
                <input type="text" value='0' readonly="readonly" data-type="number" name="gaji[{{$row->sales_code}}]" class="form-control gaji_sales">
            </div>
        </div>
        @endforeach
        <div class="row mt-5">
            <div class="col-8 pt-2">
                BEBAN OPERASIONAL
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" readonly="readonly" name="beban_ops_total" class="form-control">
            </div>
        </div>
        <div class="row"><div class="col" id="beban-wrapper"></div></div>
        {{-- <div class="row mt-1">
            <div class="col-4 pt-2">
                INVENTARIS
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" name="inventaris" class="form-control beban_ops">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-4 pt-2">
                REIMBURSE
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" name="reimburse" class="form-control beban_ops">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-4 pt-2">
                PULSA KARYAWAN
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" name="pulsa" class="form-control beban_ops">
            </div>
        </div> --}}
        <div class="row mt-5">
            <div class="col-8 pt-2">
                <b>TOTAL PENGELUARAN</b>
            </div>
            <div class="col-4">
                <input type="text" value='0' data-type="number" readonly="readonly" name="total_pengeluaran" class="form-control">
            </div>
        </div>
    </div>
    <div class="row mt-0 p-3 laporan-head text-start">
        
        <div class="row">
            <div class="col-8 pt-2">
                <b>PROFIT</b>
            </div>
            <div class="col-4">
                <input type="text" readonly="readonly" data-type="number" name="profit" class="form-control">
            </div>
        </div>
    </div>
{{-- </form> --}}
@endsection
@section('script')
<script>
    var lastAjaxData = null;
        var cash_in = 0;
        var cash_out = 0;

    $('select').on('change', function(){
        refreshData();
    });
    $('input').on('paste keyup', function(){
        processData();
    });

    function refreshData() {
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        $.ajax({
            url: '{{ url('api/data-laba-rugi') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                year: year,
                month: month
            },
        })
        .done(function(result) {
            $('.komisi_sales').val(0).change();
            $('.gaji_sales').val(0).change();
            lastAjaxData = result;
            console.log(result);
            initAjaxData();
            processData();
        });
    }

    function initAjaxData() {
        // init 
        cash_in = 0;
        var penjualan_kotor = lastAjaxData.penjualan.amount;
        $('input[name=penjualan_kotor]').val(penjualan_kotor).change();
        cash_in += penjualan_kotor;
        
        var modal_bersih = lastAjaxData.modal.modal;
        $('input[name=modal_bersih]').val(modal_bersih).change();
        $('input[name=laba_kotor]').val(penjualan_kotor - modal_bersih).change();

        var reimburse = lastAjaxData.beban.reimburse;
        $('input[name=reimburse]').val(reimburse).change();
        var inventaris = lastAjaxData.beban.inventaris;
        $('input[name=inventaris]').val(inventaris).change();
        var pulsa = lastAjaxData.beban.pulsa;
        $('input[name=pulsa]').val(pulsa).change();

        $.each(lastAjaxData.komisi, function(index, row) {
            $('input[name="komisi['+row.sales_code+']"]').val(row.total_komisi).change();
        });
        $.each(lastAjaxData.gaji, function(index, row) {
            $('input[name="gaji['+row.sales_code+']"]').val(row.amount).change();
        });
    }

    function processData() {
        cash_out = 0;
        cash_out += parseInt(lastAjaxData.modal.modal);
        // hitung komisi
        var komisi_total = 0;
        $.each($('.komisi_sales'), function(index, val) {
            cash_out += parseInt($(this).val().replace(/,/g, ''));
            komisi_total += parseInt($(this).val().replace(/,/g, ''));
        });
        $('input[name=komisi_total]').val(komisi_total).change();

        // hitung gaji
        var gaji_total = 0;
        $.each($('.gaji_sales'), function(index, val) {
            cash_out += parseInt($(this).val().replace(/,/g, ''));
            gaji_total += parseInt($(this).val().replace(/,/g, ''));
        });
        $('input[name=gaji_total]').val(gaji_total).change();

        // hitung beban
        var beban_ops_total = 0;
        // $.each($('.beban_ops'), function(index, val) {
        //     cash_out += parseInt($(this).val().replace(/,/g, ''));
        //     beban_ops_total += parseInt($(this).val().replace(/,/g, ''));
        // });
        $.each(lastAjaxData.beban, function(index, val) {
            console.log(val);
            var lines = '<div class="row mt-1">' +
                    '<div class="col-4">' +
                        '<b>' + val.sales_code + '</b><br>' + val.description +
                    '</div>' + 
                    '<div class="col-4">' +
                        '<input type="text" readonly="readonly" value=' + $.number(val.amount, 0) + ' data-type="number" name="inventaris" class="form-control beban_ops">' +
                    '</div>' +
                '</div>';
            $('#beban-wrapper').append(lines);
            cash_out += parseInt(val.amount);
            beban_ops_total += parseInt(val.amount);
        });
        $('input[name=beban_ops_total]').val(beban_ops_total).change();

        // total output
        var total_pengeluaran = komisi_total + gaji_total + beban_ops_total;
        $('input[name=total_pengeluaran]').val(total_pengeluaran).change();
        $('input[name=profit]').val(parseInt(cash_in) - parseInt(cash_out)).change();
    }



    $(document).ready(function(){
        // Step 1: Get the current month as a two-digit number
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth() + 1; // JavaScript's getMonth() returns zero-based months

        // Step 2: Format the month with leading zeros if necessary
        var formattedMonth = currentMonth.toString().padStart(2, '0');

        // Step 3: Set the value of the select element
        $('select[name=month]').val(formattedMonth).change();
        processData();
    });

    $('#printButton').on('click', function(){
        var year = $('select[name=year]').val();
        var month = $('select[name=month]').val();
        var query = new URLSearchParams({
            'month': month,
            'year': year,
        });
        window.open('{{ url('admin/print/laba-rugi-bulanan') }}?'+query.toString(), 'printWindow');
    })
</script>
@endsection