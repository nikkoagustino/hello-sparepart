<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup Account - {{ env('APP_NAME') }}</title>
  
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
        img {
            max-width: 100%;
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
        <div class="row mt-4">
            <div class="col"></div>
            <div class="col-4 text-center">
                {{ $qrcode }}
                <br>
                <p class="mt-3" style="font-size: 0.75rem">Jika tidak bisa scan QR code, masukkan manual kode di bawah ini</p>
                <textarea style="font-size: 0.8rem" readonly="readonly" cols="30" rows="3" class="form-control">{{ $secret_key }}</textarea>
            </div>
            <div class="col-4 pt-5">
                <h3>Setup 2FA Authenticator</h3>
                <ol>
                    <li>Download dan install authenticator apps seperti <a href="https://authy.com/download/" target="_blank">Authy</a> atau <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US" target="_blank">Google Authenticator</a></li>
                    <li>Scan QR code di sebelah kiri menggunakan authenticator apps</li>
                    <li>Masukkan dan verifikasi 6 digit kode OTP dari authenticator apps</li>
                </ol>
                <form action="{{ url('admin/account/2fa-setup') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="secret_key" value="{{ $secret_key }}">
                        <div class="col-6">
                            <input type="text" name="otp" placeholder="6 digit OTP" required="required" class="form-control">
                        </div>
                        <div class="col">
                            <button class="btn btn-danger form-control">Verifikasi</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>
</html>