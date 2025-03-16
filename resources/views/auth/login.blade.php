<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimun-scale=1,maximum-scale=1, viewport-fit=cover">
    <title>Login - Sistem Absensi Geolokasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo-title-absensi-2.png') }}" sizes=100x100>
    <link rel="stylesheet" href="{{ asset('assets/css/login-style.css') }}">
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="assets/img/logo-login (2).png" alt="">
        </div>
        <form action="/login" method="POST" class="p-3 mt-3">
            @csrf
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div style="font-size: small; font-weight: bold;">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="nik" id="nik" placeholder="Enter Your NIK . . .">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Enter Your Password . . .">
            </div>
            <button type="submit" class="btn mt-3 fw-bold">Login</button>
        </form>
        <div class="text-center create-account">
            <p class="">Don't Have an Account?</p>
            <a href="#">Register</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
