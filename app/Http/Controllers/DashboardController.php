<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\CutiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::now()->translatedFormat('l, d F Y');
        $totalUsers = User::count();
        $totalKaryawan = KaryawanModel::count();
        $totalAbsensiHariIni = AbsensiModel::whereDate('tgl_absen', Carbon::today())->count();
        $dataAbsensi = AbsensiModel::whereDate('tgl_absen', Carbon::today())->get();
        $dataCuti = CutiModel::where('status', 'menunggu')->get();
        $totalCutiMenunggu = CutiModel::where('status', 'menunggu')->count();
        if (Auth::user()->role == 'karyawan') {
            $karyawan = KaryawanModel::where('karyawan_users', Auth::id())->first();
            if ($karyawan) {
                $totalAbsensiSaya = AbsensiModel::where('karyawan_id', $karyawan->id_karyawan)->count();
                $totalCutiSaya = CutiModel::where('karyawan_id', $karyawan->id_karyawan)->count();
            } else {
                $totalAbsensiSaya = 0;
                $totalCutiSaya = 0;
            }
        } else {
            $karyawan = null;
            $totalAbsensiSaya = null;
            $totalCutiSaya = null;
        }
        return view('dashboard.index', compact(
            'totalUsers', 
            'totalKaryawan', 
            'totalAbsensiHariIni', 
            'totalCutiMenunggu',
            'dataAbsensi',
            'dataCuti',
            'today',
            'karyawan',
            'totalAbsensiSaya',
            'totalCutiSaya'
        ));
    }
}

     
