<?php
namespace App\Http\Controllers;

use App\Models\JabatanModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class JabatanController extends Controller
{

    public function index() : view
    {
        $data = JabatanModel::all();
        return view('jabatan.index', compact('data'));
    }
    public function create() : view
    {
        return view('jabatan.create');
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'nama_jabatan' => 'required',
        ]);
        $jabatan = new JabatanModel; 
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();     
        return redirect()->route('jabatan.index')
                         ->with('success','jabatan has been created successfully.');
    }      
    public function edit($id) : view
    {
        $data_jabatan = JabatanModel::findOrFail($id);
        return view('jabatan.edit',compact('data_jabatan'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $request->validate([
          'nama_jabatan' => 'required',
        ]);
        $jabatan = JabatanModel::findOrFail($id);
        $jabatan->nama_jabatan= $request->nama_jabatan;
        $jabatan->save();
        return redirect()->route('jabatan.index')
                         ->with('success','jabatan Has Been updated successfully');
    }
    public function destroy($id) : RedirectResponse
    {
        $jabatan = JabatanModel::findOrFail($id);
        $jabatan->delete();    
        return redirect()->route('jabatan.index')
                        ->with('success','jabatan has been deleted successfully');
    }
}

     
