<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function absensi() {
        return view('presensi.face-scan');
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
        $absensi = Absensi::where('nik', $nik)
        ->where('absensi_date', $absensi_date)
        ->first();

        if ($absensi) {
            // Jika sudah absen masuk, update jam_out & foto_out
            $absensi->update([
                'time_out' => $time,
                'photo_out' => $fileName,
                'location' => $location
            ]);
            return response()->json(['message' => 'Absensi keluar berhasil!']);
        } else {
            // Jika belum ada, buat absensi baru
            Absensi::create([
                'nik' => $nik,
                'absensi_date' => $absensi_date,
                'time_in' => $time,
                'time_out' => null, // Tambahkan ini agar tidak error
                'photo_in' => $fileName,
                'location' => $location
            ]);
            return response()->json(['message' => 'Absensi masuk berhasil!']);
        }
    }
}
