<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <style>
        
        .table {
            border: 2px solid red !important;
        }
        .table th {
            background-color: khaki;
            font-weight: bold;
            border: 1px solid red !important;
        }
        .table tr:nth-child(odd) {
            background-color: seashell;
        }
        .table td {
            border: 1px solid darkgrey;
        }
    </style>
</head>
<body>
    @yield('content')
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</body>
</html>