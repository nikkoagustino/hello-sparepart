<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: monospace;
            font-size: 1.5rem;
            text-align: left;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
        }
        thead tr th {
            border-bottom: 2px solid black;
            border-top: 2px solid black;
        }
        .table tbody tr:last-child td {
            border-bottom: 2px solid black;
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
    @yield('content')
    <br>
    <br>
    <br>
    <footer>
    {{-- Printed on: {{ date('c') }} --}}
    </footer>
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</body>
</html>