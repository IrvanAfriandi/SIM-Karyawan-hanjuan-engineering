<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('users.index', compact('data'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'role' => 'required',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        if ($request->role === 'karyawan') {
            KaryawanModel::create([
                'karyawan_users' => $user->id,
                'tgl_masuk' => now(),
            ]);
        }
        return redirect()->route('users.index')->with('success', $request->email. ' berhasil ditambahkan.');
    }
    public function edit(User $user) : View
    {
        return view('users.edit', compact('user'));
    }    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $user->role;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string',
            'role' => 'required',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);
        if ($oldRole !== 'karyawan' && $request->role === 'karyawan') {
            KaryawanModel::create([
                'karyawan_users' => $user->id,
                'tgl_masuk' => now(),
            ]);
        }
        if ($oldRole === 'karyawan' && $request->role !== 'karyawan') {
            KaryawanModel::where('karyawan_users', $user->id)->delete();
        }
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}

