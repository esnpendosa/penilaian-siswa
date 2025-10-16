<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\PenilaianSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek hak akses - hanya admin, guru_bk, dan guru yang boleh akses
        $user = Auth::user();
        $allowedRoles = ['admin', 'guru_bk', 'guru'];
        
        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/non_admin')->with('error', 'Anda tidak memiliki akses ke halaman penilaian.');
        }

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
    public function stores(Request $request)
    {
        dd($request->all());
    }

    public function store(Request $request)
    {
        // Cek hak akses - hanya admin, guru_bk, dan guru yang boleh akses
        $user = Auth::user();
        $allowedRoles = ['admin', 'guru_bk', 'guru'];
        
        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/non_admin')->with('error', 'Anda tidak memiliki akses untuk melakukan penilaian.');
        }

        $validated = $request->validate([
            'nama_siswa' => 'required',
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
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            'poin.required' => 'Kolom poin wajib diisi.',
            'poin.integer' => 'Poin harus berupa angka bulat.',
            'poin.min' => 'Poin minimal adalah 1.',
            'poin.max' => 'Poin maksimal adalah 100.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        // Validasi kategori berdasarkan jenis
        if ($request->jenis === 'prestasi') {
            $allowedKategori = ['akademik', 'nonakademik'];
            if (!in_array($request->kategori, $allowedKategori)) {
                return redirect()->back()->withErrors(['kategori' => 'Kategori prestasi tidak valid.'])->withInput();
            }
        } elseif ($request->jenis === 'pelanggaran') {
            $allowedKategori = ['ringan', 'sedang', 'berat'];
            if (!in_array($request->kategori, $allowedKategori)) {
                return redirect()->back()->withErrors(['kategori' => 'Kategori pelanggaran tidak valid.'])->withInput();
            }
        }

        $idSiswa = $request->nama_siswa;
        $siswa = DataSiswa::findOrFail($idSiswa);
        $namaSiswa = $siswa->nama;
        
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
        // Cek hak akses - hanya admin, guru_bk, dan guru yang boleh hapus
        $user = Auth::user();
        $allowedRoles = ['admin', 'guru_bk', 'guru'];
        
        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/non_admin')->with('error', 'Anda tidak memiliki akses untuk menghapus penilaian.');
        }

        $data = PenilaianSiswa::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}