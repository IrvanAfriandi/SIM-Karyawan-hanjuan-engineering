<?php
namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenKaryawanController extends Controller
{
    public function index(Request $request) : view
    {
        $karyawan = KaryawanModel::where('karyawan_users', Auth::id())->firstOrFail(); 
        $data = AbsensiModel::where('karyawan_id', $karyawan->id_karyawan)
            ->whereDate('tgl_absen', Carbon::today())
            ->get();
        return view('absen_karyawan.index', compact('data'));
    }
    public function store() : RedirectResponse
    {
        $karyawan = KaryawanModel::where('karyawan_users', Auth::id())->firstOrFail();
        $absensi = new AbsensiModel; 
        $absensi->karyawan_id = $karyawan->id_karyawan;
        $absensi->tgl_absen = Carbon::today()->toDateString();
        $absensi->status = 'hadir';
        $absensi->save(); 
        return redirect()->route('absen_karyawan.index')
                         ->with('success','Anda berhasil Absen!');
    }
}

     
