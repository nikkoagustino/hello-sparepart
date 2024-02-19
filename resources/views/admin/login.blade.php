<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - {{ config('app.name') }}</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/ca0010aa25.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        
        .btn-danger{
            background:#950101 !important;
            color: white !important;
            box-shadow: 0 0 5px grey;
        }
        .btn-danger:hover {
            color: black;
            background-color: transparent;
            border: 2px solid #950101 !important;
        }
        body {
            background-color: #f4f6f6;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>    
  
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-4 mt-5">
                <img src="{{ url('assets/img/logo.png') }}" style="max-width: 100%" alt="">
            </div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-3">
                <form action="{{ url('admin/login') }}" method="POST">
                    @csrf
                    <div class="input-group mt-5">
                        <span class="input-group-text">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="username" placeholder="Username" class="form-control" minlength="6">
                    </div>
                    <div class="input-group mt-2">
                        <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" placeholder="Password" class="form-control" minlength="6">
                    </div>
                    <button class="btn btn-danger form-control mt-3">Login</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>
</html>