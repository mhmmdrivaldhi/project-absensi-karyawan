<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class AbsensiController extends Controller
{
    public function absensi() {
        $nik = Auth::guard('employee')->user()->nik;
        $absensi_date = date("Y-m-d");

        // Cek apakah user sudah check-in hari ini
        $absensi = Absensi::where('nik', $nik)
                        ->where('absensi_date', $absensi_date)
                        ->first();

        $time_in = $absensi ? date("H:i", strtotime($absensi->time_in)) : null;
        $time_out = $absensi ? date("H:i", strtotime($absensi->time_out)) : null;

        $check = $absensi ? 1 : 0; // Cek apakah sudah ada data

        return view('presensi.face-scan', compact('check', 'time_in', 'time_out'));
    }
    public function store(Request $request) {
        $nik = Auth::guard('employee')->user()->nik;
        $absensi_date = date("Y-m-d");
        $time = date("H:i:s");
        $location = $request->location;
        $user_location = explode(",", $location);
        $latitude_user = $user_location[0];
        $longitude_user = $user_location[1];

        $latitude_office = -6.4745547;
        $longitude_office = 106.8709519;

        $distance = $this->distance($latitude_office, $longitude_office, $latitude_user, $longitude_user);
        $radius = round($distance['meters']);

        $image = $request->image;
        // Pengecekan apakah gambar terkirim
        if(!$image || !str_contains($image, 'data:image')) {
            return response()->json(['error' => 'Gambar yang anda kirim tidak valid',], 400);
        }

        $folderPath = "public/uploads/absensi/";
        $format_name = $nik. "=" .$absensi_date;
        $image_parts = explode(";base64", $image);

        // Pengecekan apakah format base64 valid
        if(count($image_parts) < 2) {
            return response()->json(['error' => 'Format gambar tidak valid'], 400);
        }

        $image_base64 = base64_decode(explode(",", $image_parts[1])[1]);
        $fileName = $format_name . ".png";
        $file = $folderPath . $fileName;
        // Penyimpanan gambar ke storage
        Storage::put($file, $image_base64);

        // pengecekan jarak dan radius
        if($radius != 20) {
            return response()->json([
                'status' => 'error',
                'message' => "You're out of Radius Range!",
            ], 400);
        } else {
            // Pengecekan Absensi masuk
            $absensi = Absensi::where('nik', $nik)
            ->where('absensi_date', $absensi_date)
            ->first();

            // Jika tidak ada, maka buat data baru (Check-In)
            if (!$absensi) {
            Absensi::create([
            'nik' => $nik,
            'absensi_date' => $absensi_date,
            'time_in' => $time,
            'time_out' => null, // Wajib di-set NULL agar tidak bermasalah
            'photo_in' => $request->image,
            'location' => $location
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Check-in Successfully!',
                'type' => 'checkin'
            ]);
            }

            // Jika sudah ada data absensi hari ini tapi belum check-out, lakukan update
            if ($absensi->time_out == null) {
            $absensi->update([
            'time_out' => $time,
            'photo_out' => $request->image,
            'location' => $request->location
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Check-out Successfully!',
                'type' => 'checkout'
            ]);
            }
            // Jika sudah melakukan check-in dan check-out di hari yang sama
            return response()->json([
                'status' => '',
                'message' => 'You have Checked In and Checked Out Today!',
            ], 400);
        }
    }

    function distance($latitude_office, $longitude_office, $latitude_user, $longitude_user) {
        $theta = $longitude_office - $longitude_user;
        $miles = (sin(deg2rad($latitude_office)) * sin(deg2rad($latitude_user))) + (cos(deg2rad($latitude_office)) * cos(deg2rad($latitude_user)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5200;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
