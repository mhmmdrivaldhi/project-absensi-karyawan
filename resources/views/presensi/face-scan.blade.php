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
        #map {
            height: 220px;
            border-radius: 10px;
        }
    </style>
@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
@section('content')
    <!-- Face Cam -->
        <div class="row" style="margin-top: 50px;">
            <div class="col">
                <input type="hidden" name="location" id="location">
                <div class="photo-facecam mt-3"></div>
            </div>
        </div>
        <div class="row">
            <button type="button" id="faceScanning" class="btn btn-outline-primary btn-block m-2"><ion-icon name="scan"></ion-icon>TAKE SCANNING FACE</button>
        </div>
        <div class="row mt-1">
            <div class="col">
                <div id="map">

                </div>
            </div>
        </div>
    <!-- * End Face Cam -->
@endsection
@push('myscript')
<script>
document.addEventListener("DOMContentLoaded", function() {
    Webcam.set({
        height: 430,
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

    // Jika mendukung Browser jalankan geolocation
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    function successCallback(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        let coordinates = latitude + "," + longitude;

        locationInput.value = coordinates;
        console.log("Lokasi berhasil didapatkan:", coordinates);

        var map = L.map('map').setView([latitude, longitude], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">Global Maps</a>'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);
        var circle = L.circle([latitude, longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 50
        }).addTo(map);
    }

    function errorCallback(error) {
        console.error("Gagal mendapatkan lokasi:", error.message);
        alert("Gagal mendapatkan lokasi: " + error.message);
    }

    $(document).ready(function(){
        $("#faceScanning").click(function(e){
            e.preventDefault();

            let imageData = '';
            let locationData = '';

            Webcam.snap(function(uri){
                imageData = uri;
                sendData();
            });

            // const locationInput = document.getElementById('location');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        locationData = position.coords.latitude + "," + position.coords.longitude;
                        $('#location').val(locationData);
                        sendData();
                        // locationInput.value = coordinates;
                    },
                    function(error) {
                        alert("Gagal mendapatkan lokasi: " + error.message);
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fungsi untuk mengirim data
            function sendData(){
                if (imageData && locationData) {
                    $.ajax({
                        type: 'POST',
                        url: '/absensi/store',
                        data: {
                        image: imageData,
                        location: locationData,
                        },
                        cache: false,
                        success: function(respond){
                            alert('You Have Successfully Checked in!')
                        },
                        error: function(xhr, status, error) {
                            alert('Oops, There is an error!')
                        }
                    });
                }
            }
        });
    });
});

</script>
@endpush
