<?php
namespace App\Http\Controllers;
use App\Models\JenisCutiModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisCutiController extends Controller
{

    public function index() : view
    {
        $data = JenisCutiModel::all();
        return view('jenis_cuti.index', compact('data'));
    }
    public function create() : view
    {
        return view('jenis_cuti.create');
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'nama_cuti' => 'required',
        ]);
        $jenis_cutus = new JenisCutiModel; 
        $jenis_cutus->nama_cuti = $request->nama_cuti;
        $jenis_cutus->save();     
        return redirect()->route('jenis_cuti.index')
                         ->with('success','jenis_cuti has been created successfully.');
    }
    public function edit($id) : view
    {
        $data_jenis_cuti = JenisCutiModel::findOrFail($id);
        return view('jenis_cuti.edit',compact('data_jenis_cuti'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $request->validate([
          'nama_cuti' => 'required',
        ]);
        $jenis_cuti = JenisCutiModel::findOrFail($id); 
        $jenis_cuti->nama_cuti= $request->nama_cuti;
        $jenis_cuti->save();
        return redirect()->route('jenis_cuti.index')
                         ->with('success','jenis cuti Has Been updated successfully');
    }
    public function destroy($id) : RedirectResponse
    {
        $jenis_cuti = JenisCutiModel::findOrFail($id);
        $jenis_cuti->delete();    
        return redirect()->route('jenis_cuti.index')
                        ->with('success','jenis cuti has been deleted successfully');
    }
}

     
