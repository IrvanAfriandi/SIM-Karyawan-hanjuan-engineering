<?php
namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request) : view
    {
        $data = AbsensiModel::orderBy('id_absensi', 'asc')->get();
        return view('absensi.index', compact('data'));
    }
    public function create() : view
    {
        $karyawan = KaryawanModel::orderBy('divisi_id', 'asc')->get();
        return view('absensi.create', compact('karyawan'));
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'karyawan_id' => 'required',
          'tgl_absen' => 'required',
          'status' => 'required',
        ]);
        $absensi = new AbsensiModel; 
        $absensi->karyawan_id = $request->karyawan_id;
        $absensi->tgl_absen = $request->tgl_absen;
        $absensi->status = $request->status;
        $absensi->save();     
        return redirect()->route('absensi.index')
                         ->with('success','absensi has been created successfully.');
    }
    public function edit($id) : view
    {
        $data_absensi = AbsensiModel::findOrFail($id);
        return view('absensi.edit',compact('data_absensi'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $request->validate([
          'tgl_absen' => 'required',
          'status' => 'required',
        ]);
        $absensi = AbsensiModel::findOrFail($id); 
        $absensi->tgl_absen= $request->tgl_absen;
        $absensi->status= $request->status;
        $absensi->save();
        return redirect()->route('absensi.index')
                         ->with('success','absensi Has Been updated successfully');
    }
    public function destroy(AbsensiModel $absensi) : RedirectResponse
    {
        $absensi->delete();    
        return redirect()->route('absensi.index')
                        ->with('success','absensi has been deleted successfully');
    }
}

     
