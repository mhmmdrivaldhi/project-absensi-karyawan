<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $nik = Auth::guard('employee')->user()->nik;
        $absensi = Absensi::where('nik', $nik) ->whereDate('absensi_date', now()->toDateString())->first();

        $time_in = $absensi ? Carbon::parse($absensi->time_in)->format('H:i') : null;
        $time_out = $absensi ? Carbon::parse($absensi->time_out)->format('H:i') : null;
        return view('dashboard.dashboard', compact('employee', 'time_in', 'time_out'));
    }
}
