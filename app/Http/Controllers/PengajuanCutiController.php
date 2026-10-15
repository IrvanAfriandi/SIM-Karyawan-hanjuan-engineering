<?php
namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\CutiModel;
use App\Models\JenisCutiModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengajuanCutiController extends Controller
{
    public function index(Request $request) : view
    {
        $karyawan = KaryawanModel::where('karyawan_users', Auth::id())->firstOrFail(); 
        $data = CutiModel::where('karyawan_id', $karyawan->id_karyawan)
                ->orderBy('id_cuti', 'desc')
                ->get();
        $jenis_cuti = JenisCutiModel::all();
        return view('pengajuan_cuti.index', compact('data', 'jenis_cuti'));

    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'jenis_cuti' => 'required',
          'tgl_mulai' => 'required',
          'tgl_selesai' => 'required',
          'alasan' => 'required',
        ]);
        $karyawan = KaryawanModel::where('karyawan_users', Auth::id())->firstOrFail(); 
        $cuti = new CutiModel; 
        $cuti->karyawan_id = $karyawan->id_karyawan;
        $cuti->jenis_cuti = $request->jenis_cuti;
        $cuti->tgl_mulai = $request->tgl_mulai;
        $cuti->tgl_selesai = $request->tgl_selesai;
        $cuti->alasan = $request->alasan;
        $cuti->save();     
        return redirect()->route('pengajuan_cuti.index')
                         ->with('success','Pengajuan cuti berhasil diajukan');
    }
}

     
