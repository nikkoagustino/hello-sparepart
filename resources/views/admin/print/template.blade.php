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
            font-family: sans-serif;
            font-size: 1rem;
            text-align: left;
        }
        h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-top: 0;
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
        .table tbody tr:last-child td {
            border-bottom: 2px solid black;
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
    <header>{{ date('d/m/y H:i') }}</header>
    @yield('content')
    <footer>
    {{-- Printed on: {{ date('c') }} --}}
    </footer>
</body>
</html>