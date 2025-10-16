<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.user', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,kepsek,guru_bk,siswa',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        if ($user->role === 'siswa') {
            DataSiswa::create([
                'nama' => $user->name,
                'nis' => 0,
                'kelas' => 'X',
                'status' => '1',
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        dd($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,guru,kepsek,guru_bk,siswa',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route('users.index')->with('success', 'Data berhasil dihapus');
    }
}