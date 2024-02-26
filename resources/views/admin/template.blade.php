<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @yield('meta')
  
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/ca0010aa25.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js" integrity="sha512-3z5bMAV+N1OaSH+65z+E0YCCEzU8fycphTBaOWkvunH9EtfahAlcJqAVN2evyg0m7ipaACKoVk6S9H2mEewJWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ url('assets/js/date.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body {
            line-height: 2rem;
        }
        img {
            max-width: 100%;
        }
        .input-group-text,
        .form-control {
            border: 2px solid rgba(var(--bs-danger-rgb),var(--bs-bg-opacity))!important;
            border-radius: 0;
        }
        .btn.form-control {
            border-radius: 50px !important;
        }
        .form-control:disabled {
            background: #fdf4e6;
        }
        #sidebar {
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            padding-top: 80px !important;
            padding-left: 40px !important;
            padding-right: 40px !important;
        }
        #sidebar .btn {
            text-align: left !important;
            padding: .6rem 2rem;
        }
        #sidebar .btn i {
            width: 1.5rem;
        }
        .btn-icon-lg {
            text-align: center;
            padding: 10px 20px;
        }
        .btn-icon-lg img {
            /*white*/
            height: 2.5rem;
            display: block;
            filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(7491%) hue-rotate(254deg) brightness(102%) contrast(102%);
        }
        .btn-icon-lg:hover img {
            /*red*/
            filter: brightness(0) saturate(100%) invert(11%) sepia(63%) saturate(6689%) hue-rotate(351deg) brightness(91%) contrast(84%);
        }
        .btn:hover {
            background-color: white !important;
            color: #444 !important;
            border: 1px solid #444 !important;
        }
        .btn-icon-lg i {
            font-size: 2.5rem;
            display: block;
        }
        .btn-form {
            border-radius: 0 !important;
            box-shadow: none;
        }
        .btn-selection {
            font-weight: bold;
            text-align: center;
            width: 100%;
            aspect-ratio: 1/1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-radius: 25px;
        }
        .btn-selection img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 10px;
        }
        .btn-purple {
            background-color: #bec1d8;
        }
        .btn-pink {
            background-color: #e3b597;
        }
        .btn-blue {
            background-color: #bfdfde;
        }
        .btn-yellow {
            background-color: #e0b05e;
        }
        .btn-red {
            background-color: #d08380;
        }
        .btn-green {
            background-color: #9cbd93;
        }
        .table {
            border: 2px solid rgba(var(--bs-danger-rgb),var(--bs-bg-opacity))!important;
        }
        .table th {
            background-color: #e0b05e;
            font-weight: bold;
            border: 1px solid rgba(var(--bs-danger-rgb),var(--bs-bg-opacity))!important;
            text-align: center;
        }
        .table tr:nth-child(odd) {
            background-color: seashell;
        }
        .selectable tbody tr {
            cursor: pointer;
        }
        .table td {
            border: 1px solid darkgrey;
        }
        .breadcrumb .btn {
            margin-right: 5px;
            border-radius: 50px;
            background: rgba(var(--bs-danger-rgb),1) !important;
            border-color: rgba(var(--bs-danger-rgb),1) !important;
        }
        .breadcrumb .btn:hover {
            background-color: transparent !important;
            color: rgba(var(--bs-danger-rgb),1) !important;
            border-color: rgba(var(--bs-danger-rgb),1) !important;
        }
        .btn-danger {
            background: rgba(var(--bs-danger-rgb),1) !important;
            border-color: rgba(var(--bs-danger-rgb),1) !important;
        }
        .btn-danger:hover {
            color: rgba(var(--bs-danger-rgb),1) !important;
            border-color: rgba(var(--bs-danger-rgb),1) !important;
        }
        tr.selected td {
            color: rgba(var(--bs-danger-rgb),1) !important;
            font-weight: bold;
        }
        tfoot td {
            font-weight: bold;
        }
        [readonly] {
            background-color: #fef6e9 !important;
        }
        select[readonly] {
            pointer-events: none;
        }
        /*
        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
            .col-print-12 {
                width: 100% !important;
            }
            .bg-light {
                background-color: transparent !important;
            }
            .btn-icon-lg {
                display: none !important;
            }
        }
        */
        .floating-select {
            position: absolute;
            top: 100%;
            width: calc(100% - 25px);
            z-index: 1;
            background-color: antiquewhite;
            padding: 0;
        }
        .floating-select li {
            list-style-type: none;
            border-bottom: 1px solid grey;
            cursor: pointer;
            padding: 10px 20px;
        }
        .modal-body {
            border: 4px solid crimson;
        }
        .laporan-head {
            margin: 10px;
            text-align: center;
            background-color: antiquewhite;
            border: 1px solid crimson;
        }
        .laporan-head .fa-solid {
            padding-top: 10px;
        }
        .laporan-head .col-3 {
            border-right: 1px solid crimson;
        }
        .alert {
            position: fixed;
            top: 50px;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 20px grey;
        }

        .icon-lg {
            filter: brightness(0);
            width: 50%;
            aspect-ratio: 1/1;
        }
        #sidebar .btn {
            background-color: #211d1e !important;
            border: none !important;
            color: white !important;
            font-weight: bold;
            position: relative;
        }
        #sidebar .btn:hover,
        #sidebar .btn.active {
            background-color: rgba(var(--bs-light-rgb),1) !important;
            color: rgba(var(--bs-danger-rgb),1) !important;
        }
        #sidebar .btn.active:after {
            display: block;
            position: absolute;
            right: -40px;
            top: 0;
            width: 60px;
            height: 100%;
            background-color: rgba(var(--bs-light-rgb),1) !important;
            content: ' ';
        }
        #sidebar .btn img {
            width: 25px;
            margin-right: 10px;
            vertical-align: baseline;
            margin-bottom: -3px;
            filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(7491%) hue-rotate(254deg) brightness(102%) contrast(102%);
        }
        #sidebar .btn:hover img,
        #sidebar .btn.active img {
            filter: brightness(0) saturate(100%) invert(11%) sepia(63%) saturate(6689%) hue-rotate(351deg) brightness(91%) contrast(84%);
        }
        .breadcrumb .btn img {
            height: 1rem;
            /*white*/
            filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(7491%) hue-rotate(254deg) brightness(102%) contrast(102%);
        }
        .breadcrumb .btn:hover img {
            /*red*/
            filter: brightness(0) saturate(100%) invert(11%) sepia(63%) saturate(6689%) hue-rotate(351deg) brightness(91%) contrast(84%);
        }
        :root {
          --bs-danger-rgb: 170,30,36;
        }
        .bg-khaki {
            background-color: khaki !important;
        }
    </style>

</head>
<body class="bg-light">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid">

        <div class="row no-print" style="border-bottom: 2px solid darkred;
    border-bottom-right-radius: 100px; background-color: white !important">
            <div class="col-3">
                <img src="{{ url('assets/img/logo.png') }}" style="height: 70px" alt="">
            </div>
            <div class="col-9 pt-2 text-center">
                <span class="fs-2">Welcome <b>{{ Session::get('userdata')->username ?? '' }}</b></span>
            </div>
        </div>

        <div class="row">
            <div class="no-print col-3 min-vh-100 p-0 bg-danger" id="sidebar">
                <a href="{{ url('admin/dashboard') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/dashboard') ? 'active' : '') }}">
                    {{-- <i class="fa-solid fa-cubes"></i> Dashboard --}}
                    <img src="{{ url('assets/img/svg/sidebar-dashboard.svg') }}" alt=""> Dashboard
                </a>
                <a href="{{ url('admin/master') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/master') ? 'active' : '') }}">
                    {{-- <img src="{{ url('assets/img/svg/sidebar-master.svg') }}"> Master --}}
                    <img src="{{ url('assets/img/svg/sidebar-master.svg') }}" alt=""> Master
                </a>
                <a href="{{ url('admin/account') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/account') ? 'active' : '') }}">
                    {{-- <i class="fa-solid fa-users"></i> Account --}}
                    <img src="{{ url('assets/img/svg/sidebar-account.svg') }}" alt=""> Account
                </a>
                <a href="{{ url('admin/penjualan') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/penjualan') ? 'active' : '') }}">
                    {{-- <i class="fa-solid fa-hand-holding-dollar"></i> Penjualan --}}
                    <img src="{{ url('assets/img/svg/sidebar-penjualan.svg') }}" alt=""> Penjualan
                </a>
                <a href="{{ url('admin/pembelian') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/pembelian') ? 'active' : '') }}">
                    {{-- <i class="fa-solid fa-store"></i> Pembelian --}}
                    <img src="{{ url('assets/img/svg/sidebar-pembelian.svg') }}" alt=""> Pembelian
                </a>
                <a href="{{ url('admin/laporan') }}" class="btn form-control mt-3 {{ (Str::contains(Request::path(), 'admin/laporan') ? 'active' : '') }}">
                    {{-- <i class="fa-solid fa-chart-bar"></i> Laporan --}}
                    <img src="{{ url('assets/img/svg/sidebar-laporan.svg') }}" alt=""> Laporan
                </a>
                <div class="mt-5"></div>
                <a href="{{ url('admin/logout') }}" class="btn px-3 mt-5">
                    <center>
                    <i class="fa-solid fa-door-open"></i><br>Logout
                    </center>
                </a>
            </div>

            <div class="col-9 col-print-12 min-vh-100">
                <div class="breadcrumb">
                    <div class="row pt-3">
                        <div class="col">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
                <div class="container px-2 mb-5">
                @yield('content')
                </div>
            </div>

        </div>
    </div>


<!-- Modal -->
<div class="modal modal-sm fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-danger text-light text-center">
                <p class="py-2">PIN</p>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="pin" placeholder="PIN" aria-label="PIN" aria-describedby="spillPIN">
                    <button class="btn btn-danger" type="button" id="spillPIN">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <button id="submitPIN" class="btn form-control btn-light">
                            LOGIN
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn form-control btn-light" data-bs-dismiss="modal" aria-label="Close">
                            CANCEL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-sm fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-danger text-light text-center">
                <p class="py-2">PIN</p>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="delete_pin" placeholder="PIN" aria-label="PIN" aria-describedby="spillPINDelete">
                    <button class="btn btn-danger" type="button" id="spillPINDelete">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <button id="submitPINDelete" class="btn form-control btn-light">
                            LOGIN
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn form-control btn-light" data-bs-dismiss="modal" aria-label="Close">
                            CANCEL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 
<!-- Modal -->
<div class="modal modal-sm fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-danger text-light text-center">
                <p class="py-2">DELETE ?</p>
                <div class="row my-2">
                    <div class="col">
                        <a class="btn form-control btn-light" id="deleteAction">
                            YA
                        </a>
                    </div>
                    <div class="col">
                        <button class="btn form-control btn-light" data-bs-dismiss="modal" aria-label="Close">
                            CANCEL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('Copied to Clipboard')
        }

        // var selected_row;

        // $('.selectable').on('click', 'tbody tr', function() {
        //     selected_row = $(this).data('id');
        //     $('tr').removeClass('selected');
        //     $('tr[data-id="'+selected_row+'"]').addClass('selected');
        // });
    
        $('button[type=back]').on('click', function(e) {
          e.preventDefault();
          
          var currentURL = window.location.href;
          var previousURL = document.referrer;
          
          if (previousURL === currentURL) {
            // If the previous URL is the same as the current one, navigate to 2 page before
            history.back(2);
          } else {
            // If the previous URL is different, use history.back()
            history.back();
          }
        });


        $('input[data-type=number]').on('change paste keyup', function(){
            var value = $(this).val();
            value = value.replace(/[^\d.-]/g, "");
            if (!value) {
                $(this).val(0);
                return;
            }
            var formatted = parseInt(value).toLocaleString('en-US');
            $(this).val(formatted);
        });
        $('form').on('submit', function(){
            event.preventDefault();
            $('input[data-type=number]').each(function() {
                var submitvalue = $(this).val();
                submitvalue = submitvalue.replace(/[^\d]/g, "");
                $(this).val(submitvalue);
            });
            $(this).unbind('submit').submit();
        });

        // $('#printButton').on('click', function(){
        //     var tables = document.querySelectorAll('table.print');

        //     // Create a new window for printing
        //     var printWindow = window.open('', '', 'width=800,height=600');
        //     // Set the CSS style for table width
        //     var style = '<style>table { width: 100%; font-family:monospace; font-size:1.5rem; text-align:left; }</style>';
        //     printWindow.document.write(style);

        //     // Iterate through each table and append it to the print window
        //     tables.forEach(function(table) {
        //     printWindow.document.write(table.outerHTML);
        //     printWindow.document.write('<br>');
        //     });

        //     // Print the contents of the print window
        //     printWindow.print();
        //     printWindow.close();
        // });

        $('#spillPIN').on('mousedown', function(){
            $('input[name=pin]').prop('type', 'text');
        });
        $('#spillPIN').on('mouseup', function(){
            $('input[name=pin]').prop('type', 'password');
        });

        $('#spillPINDelete').on('mousedown', function(){
            $('input[name=delete_pin]').prop('type', 'text');
        });
        $('#spillPINDelete').on('mouseup', function(){
            $('input[name=delete_pin]').prop('type', 'password');
        });

        $('#editButton').on('click', function(event){
            event.preventDefault();
            $('#pinModal input[name=pin]').val('');
            $('#pinModal').modal('show');
        });

        $('#submitPIN').on('click', function(){
            var pin = $('input[name=pin]').val();
            $.ajax({
                url: '{{ url('api/verify-pin') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    pin: pin,
                    username: '{{ Session::get('userdata')->username }}',
                },
            })
            .done(function(result) {
                $('#editButton').hide();
                $('#saveButton').show();
                enableEdit();
                $('#pinModal').modal('hide');
            })
            .fail(function(result) {
                alert(result.responseJSON.message);
            })
            .always(function() {
            });
        });

        $('#submitPINDelete').on('click', function(){
            var pin = $('input[name=delete_pin]').val();
            $.ajax({
                url: '{{ url('api/verify-pin') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    pin: pin,
                    username: '{{ Session::get('userdata')->username }}',
                },
            })
            .done(function(result) {
                enableDelete();
                $('#deleteModal').modal('hide');
            })
            .fail(function(result) {
                alert(result.responseJSON.message);
            })
            .always(function() {
            });
        });

        $('input[name=invoice_no]').on('change paste keyup', function(){
            var regex = /^[a-zA-Z0-9_\.\-\/]+$/;
            var value = $(this).val();
            if (!regex.test(value)) {
                $(this).val(value.replace(/[^a-zA-Z0-9_\.\-\/]+/g, ''));
            }
        });

        $(document).ready(function() {
          setTimeout(function() {
            $(".alert").alert('close');
          }, 5000);
        });

        
        $('select[name=sales_code_name]').on('change', function(){
            $('select[name=sales_code]').val($(this).val());
        });
        $('select[name=sales_code]').on('change', function(){
            $('select[name=sales_code_name]').val($(this).val());
        });
        
        $('select[name=customer_code_name]').on('change', function(){
            $('select[name=customer_code]').val($(this).val());
        });
        $('select[name=customer_code]').on('change', function(){
            $('select[name=customer_code_name]').val($(this).val());
        });
        
        $('select[name=supplier_code_name]').on('change', function(){
            $('select[name=supplier_code]').val($(this).val());
        });
        $('select[name=supplier_code]').on('change', function(){
            $('select[name=supplier_code_name]').val($(this).val());
        });
        
        $('select[name=type_code_name]').on('change', function(){
            $('select[name=type_code]').val($(this).val());
        });
        $('select[name=type_code]').on('change', function(){
            $('select[name=type_code_name]').val($(this).val());
        });
    </script>
    @yield('script')
</body>
</html>
