@extends('layouts.absensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E - ABSENSI</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
        .photo-facecam,
        .photo-facecam video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 30px;
        }
    </style>
@endsection

@section('content')
    <!-- Face Cam -->
        <div class="row" style="margin-top: 130px;">
            <div class="col">
                <input type="hidden" name="location" id="location">
                <div class="photo-facecam mt-3"></div>
            </div>
        </div>
        <div class="row">
            <button type="button" id="faceScanning" class="btn btn-outline-primary btn-block m-3"><ion-icon name="scan"></ion-icon>TAKE SCANNING FACE</button>
        </div>
    <!-- * End Face Cam -->
@endsection
@push('myscript')
<script>
document.addEventListener("DOMContentLoaded", function() {
    Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.photo-facecam');

    const locationInput = document.getElementById('location');

    if (!locationInput) {
        console.error("Elemen input lokasi tidak ditemukan!");
        return;
    }

    // Cek apakah browser mendukung Geolocation API
    if (!navigator.geolocation) {
        alert("Browser ini tidak mendukung geolocation. Silakan masukkan lokasi secara manual.");
        locationInput.placeholder = "Masukkan lokasi Anda...";
        return;
    }

    // Jika mendukung, jalankan geolocation
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    function successCallback(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        let coordinates = latitude + "," + longitude;

        locationInput.value = coordinates;
        console.log("Lokasi berhasil didapatkan:", coordinates); // Debugging

        // // Debugging URL sebelum redirect
        // let redirectUrl = "/absensi";
        // console.log("Redirecting to:", redirectUrl);

        // // Redirect dengan sedikit delay agar data terisi dengan benar
        // setTimeout(() => {
        //     window.location.href = redirectUrl;
        // }, 500);
    }

    function errorCallback(error) {
        console.error("Gagal mendapatkan lokasi:", error.message);
        alert("Gagal mendapatkan lokasi: " + error.message);
    }
});
</script>
@endpush
