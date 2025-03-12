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
