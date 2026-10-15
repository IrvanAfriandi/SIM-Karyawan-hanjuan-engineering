<?php
namespace App\Http\Controllers;

use App\Models\KaryawanModel;
use App\Models\DivisiModel;
use App\Models\JabatanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index(Request $request) : view
    {
        $data = KaryawanModel::orderBy('karyawan_users', 'asc')->get();
        return view('karyawan.index', compact('data'));
    }
    public function create() : view
    {
        $divisi = DivisiModel::all();
        $jabatan = JabatanModel::all();
        return view('karyawan.create', compact('divisi', 'jabatan'));
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'name' => 'required',
          'email' => 'required',
          'password' => 'required',
          'divisi_id' => 'required',
          'jabatan_id' => 'required',
          'nik' => 'required',
          'tgl_masuk' => 'required',
          'foto' => 'required',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $karyawan = new KaryawanModel; 
        $karyawan->karyawan_users = $user->id;
        $karyawan->jabatan_id = $request->jabatan_id;
        $karyawan->divisi_id = $request->divisi_id;
        $karyawan->nik = $request->nik;
        $karyawan->tgl_masuk = $request->tgl_masuk;
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $karyawan->foto = $imageName;
        }
        $karyawan->save();     
        return redirect()->route('karyawan.index')
                         ->with('success','karyawan has been created successfully.');
    }
    public function edit(KaryawanModel $karyawan) : view
    {
        $divisi = DivisiModel::all();
        $jabatan = JabatanModel::all();
        return view('karyawan.edit',compact('karyawan', 'divisi', 'jabatan'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $karyawan = KaryawanModel::findOrFail($id);
        $us = $karyawan->karyawan_users;
        $user = User::findOrFail($us);
        $user->update([
            'name' => $request->name,
        ]);
        $karyawan->jabatan_id= $request->jabatan_id;
        $karyawan->divisi_id= $request->divisi_id;
        $karyawan->nik= $request->nik;
        $karyawan->tgl_masuk= $request->tgl_masuk;
        if ($request->hasFile('foto')) {
            if ($karyawan->foto) {
                $oldImagePath = public_path('images') . '/' . $karyawan->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName);
            $karyawan->foto = $imageName; 
        }
        $karyawan->save();
        return redirect()->route('karyawan.index')
                         ->with('success','karyawan Has Been updated successfully');
    }
    public function destroy(KaryawanModel $karyawan) : RedirectResponse
    {
        $karyawan->delete();    
        return redirect()->route('karyawan.index')
                        ->with('success','karyawan has been deleted successfully');
    }
}

     
