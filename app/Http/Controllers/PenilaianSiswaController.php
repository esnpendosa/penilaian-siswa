<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\PenilaianSiswa;
use Illuminate\Http\Request;

class PenilaianSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSiswa = DataSiswa::all();
        $penilaianSiswa = PenilaianSiswa::orderByDesc('created_at')->get();
        return view('penilaian', compact('dataSiswa', 'penilaianSiswa'));
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
    public function stores(Request $request){
        dd($request->all());
    }
    public function store(Request $request)
    {
        $validated = $request->validate([  
        'nama_siswa' =>  'required',     
        'jenis' => 'required|in:prestasi,pelanggaran',
        'kategori' => 'required',
        'keterangan' => 'required|string|max:255',
        'poin' => 'required|integer|min:1|max:100',
        'tanggal' => 'required|date',
        ], [                             
            'nama_siswa.required' => 'Siswa harus dipilih.',
            'jenis.required' => 'Jenis penilaian harus dipilih.',
            'jenis.in' => 'Jenis penilaian tidak valid.',
            'kategori.required' => 'Kategori penilaian harus dipilih.',
            'kategori.in' => 'Kategori tidak valid.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            'poin.required' => 'Kolom poin wajib diisi.',
            'poin.integer'  => 'Poin harus berupa angka bulat.',
            'poin.min'      => 'Poin minimal adalah 1.',
            'poin.max'      => 'Poin maksimal adalah 100.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        $idSiswa = $request->nama_siswa;
        $nama = DataSiswa::findOrFail($idSiswa)->first();
        $namaSiswa = $nama->nama;
        $validated['nama_siswa'] = $namaSiswa;
        $validated['siswa_id'] = $idSiswa;
        PenilaianSiswa::create($validated);

        return redirect()->back()->with('success', 'Data penilaian berhasil disimpan.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PenilaianSiswa::findOrFail($id);
        $data ->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
