<?php
namespace App\Http\Controllers;

use App\Models\CutiModel;
use App\Models\KaryawanModel;
use App\Models\JenisCutiModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CutiController extends Controller
{
    public function index(Request $request) : view
    {
        $data = CutiModel::orderByRaw(
            "CASE 
                WHEN status = 'menunggu' THEN 1 
                WHEN status = 'disetujui' THEN 2 
                WHEN status = 'ditolak' THEN 3 
                ELSE 4 
            END"
        )->get();
        return view('cuti.index',compact('data'));
    }
    public function create() : view
    {
        $karyawan = KaryawanModel::all();
        $jenis_cuti = JenisCutiModel::all();
        return view('cuti.create', compact('karyawan', 'jenis_cuti'));
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'karyawan_id' => 'required',
          'jenis_cuti' => 'required',
          'tgl_mulai' => 'required',
          'tgl_selesai' => 'required',
          'status' => 'required',
          'alasan' => 'required',
        ]);
        $cuti = new CutiModel; 
        $cuti->karyawan_id = $request->karyawan_id;
        $cuti->jenis_cuti = $request->jenis_cuti;
        $cuti->tgl_mulai = $request->tgl_mulai;
        $cuti->tgl_selesai = $request->tgl_selesai;
        $cuti->status = $request->status;
        $cuti->alasan = $request->alasan;
        $cuti->save();     
        return redirect()->route('cuti.index')
                         ->with('success','cuti has been created successfully.');
    }
    public function edit($id) : view
    {
        $cuti = CutiModel::findOrFail($id);
        $karyawan = KaryawanModel::all();
        $jenis_cuti = JenisCutiModel::all();
        return view('cuti.edit',compact('cuti','karyawan', 'jenis_cuti'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $cuti = CutiModel::findOrFail($id);
        $cuti->status = $request->status;
        $cuti->save();

        $pesan = $request->status === 'disetujui' ? 'Cuti telah disetujui!' : 'Cuti telah ditolak!';
        return redirect()->route('cuti.index')
                         ->with('success',$pesan);
    } 
    public function destroy($id) : RedirectResponse
    {
        $cuti = CutiModel::findOrFail($id);
        $cuti->delete();    
        return redirect()->route('cuti.index')
                        ->with('success','cuti has been deleted successfully');
    }
}