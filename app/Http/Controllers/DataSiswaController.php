<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataSiswaRequest;
use App\Models\DataSiswa;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
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
    public function store(DataSiswaRequest $request)
    {
        $validated = $request->validated();

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
    public function update(DataSiswaRequest $request, $id)
    {
        $validated = $request->validated();

        // Ambil data siswa dari database
        $siswa = DataSiswa::findOrFail($id);

        // Update data siswa
        $siswa->nama = $validated['nama'];
        $siswa->nis = $validated['nis'];
        $siswa->kelas = $validated['kelas'];
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
