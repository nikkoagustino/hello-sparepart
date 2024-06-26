<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @page { 
            margin: 20px;
        }
        body {
            font-family: sans-serif !important;
            font-size: 1rem;
            text-align: left;
            line-height: 1.5rem;
        }
        h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-top: 0;
            text-transform: uppercase;
            text-decoration: underline;
        }
        table {
            width: 100%;
        }
        thead tr th {
            border-bottom: 2px solid black;
            border-top: 2px solid black;
            padding-top: 7px;
            padding-bottom: 7px;
            text-align: left;
        }
        th, td {
            padding-left: 4px;
            padding-right: 4px;
        }
        .border-bottom td {
            padding-bottom: 7px;
            border-bottom: 2px solid black;
        }
        .table tbody tr:last-child td{
            border-bottom: 2px solid black;
            padding-bottom: 7px;
        }
        .table tfoot tr td {
            font-weight: bold;
        }
        header {
            font-weight: 400;
            text-align: right;
        }
        footer {
            font-size: 1rem;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>
    @php date_default_timezone_set('Asia/Jakarta'); @endphp
    @if ((!Str::contains(request()->url(), 'surat-jalan')) && (!Str::contains(request()->url(), 'invoice')))
    <header>{{ date('d/m/y H:i') }}</header>
    @endif
    @yield('content')
    <footer>
    {{-- Printed on: {{ date('c') }} --}}
    </footer>
</body>
</html>