<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @page { 
            margin-left:20px;
            margin-right:20px;
            margin-top: 0px;
        }
        body {
            font-family: sans-serif;
            font-size: 1.2rem;
            text-align: left;
        }
        h1 {
            text-align: center;
            font-size: 1.8rem;
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