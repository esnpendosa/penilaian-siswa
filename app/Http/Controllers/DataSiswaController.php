<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSiswa = DataSiswa::all();
        return view('data_siswa', compact('dataSiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'nis' => 'required|string|unique:data_siswa,nis|digits:7',
        'kelas' => 'required|in:X,XI,XII',
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS tidak boleh kosong.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nis.digits' => 'NIS harus berupa 7 digit angka.',
            'kelas.required' => 'Silakan pilih kelas siswa.',
            'kelas.in' => 'Kelas tidak valid.',
        ]);

        DataSiswa::create([
            'nama' => $validated['nama'],
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
            'status' => '',
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataSiswa = DataSiswa::findOrFail($id);
        return view('edit_siswa', compact('dataSiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Validasi input
        $request->validate([
        'nama' => 'required|string|max:100',
        'nis' => 'required|string|digits:7|unique:data_siswa,nis,'.$id,
        'kelas' => 'required|in:X,XI,XII',
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'nis.required' => 'NIS tidak boleh kosong.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nis.digits' => 'NIS harus berupa 7 digit angka.',
            'kelas.required' => 'Silakan pilih kelas siswa.',
            'kelas.in' => 'Kelas tidak valid.',
        ]);

        // Ambil data siswa dari database
        $siswa = DataSiswa::findOrFail($id);

        // Update data siswa
        $siswa->nama = $request->input('nama');
        $siswa->nis = $request->input('nis');
        $siswa->kelas = $request->input('kelas');
        $siswa->save();

        // Redirect kembali ke halaman index atau detail
        return redirect()->route('data_siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DataSiswa::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
