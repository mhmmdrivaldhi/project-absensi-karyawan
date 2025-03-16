<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function absensi() {
        return view('presensi.face-scan');
    }
}
