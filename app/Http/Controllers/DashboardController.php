<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $nik = Auth::guard('employee')->user()->nik;
        $absensi = Absensi::where('nik', $nik)->whereDate('absensi_date', now()->toDateString())->first();

        $time_in = $absensi ? Carbon::parse($absensi->time_in)->format('H:i') : null;
        $time_out = $absensi ? Carbon::parse($absensi->time_out)->format('H:i') : null;

        $photo_in = $absensi ? $absensi->photo_in : null;
        $photo_out = $absensi ? $absensi->photo_out : null;

        $month = date('m');
        $year = date('Y');
        $photo_history = DB::table('absensi')
        ->whereRaw('MONTH(absensi_date) = "' . $month . '"' )
        ->whereRaw('YEAR(absensi_date) ="' . $year . '"')
        ->orderBy('absensi_date')
        ->get();
        return view('dashboard.dashboard', compact('employee', 'time_in', 'time_out', 'absensi', 'photo_in', 'photo_out', 'photo_history'));
    }
}
