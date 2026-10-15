<?php
namespace App\Http\Controllers;

use App\Models\DivisiModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DivisiController extends Controller
{
    public function index() : view
    {
        $data = DivisiModel::all();
        return view('divisi.index', compact('data'));
    }
    public function create() : view
    {
        return view('divisi.create');
    }
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
          'nama_divisi' => 'required',
        ]);
        $divisi = new DivisiModel; 
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->save();     
        return redirect()->route('divisi.index')
                         ->with('success','divisi has been created successfully.');
    }
    public function edit($id) : view
    {
        $data_divisi = DivisiModel::findOrFail($id); 
        return view('divisi.edit',compact('data_divisi'));
    }
    public function update(Request $request, $id) : RedirectResponse
    {
        $request->validate([
          'nama_divisi' => 'required',
        ]);
        $divisi = DivisiModel::findOrFail($id); 
        $divisi->nama_divisi= $request->nama_divisi;
        $divisi->save();
        return redirect()->route('divisi.index')
                         ->with('success','divisi Has Been updated successfully');
    }
    public function destroy($id) : RedirectResponse
    {
        $divisi = DivisiModel::findOrFail($id); 
        $divisi->delete();    
        return redirect()->route('divisi.index')
                        ->with('success','divisi has been deleted successfully');
    }
}

     
