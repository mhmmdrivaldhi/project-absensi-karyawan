<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        // Pengecekan Absensi masuk
            // Cek apakah ada data absensi hari ini
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
        return response()->json(['error' => 'Anda sudah melakukan check-in dan check-out hari ini'], 400);

    }
}
