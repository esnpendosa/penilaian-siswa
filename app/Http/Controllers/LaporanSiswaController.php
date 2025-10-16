<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cek hak akses
        $user = Auth::user();
        $allowedRoles = ['admin', 'guru_bk', 'guru', 'siswa'];
        
        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/non_admin')->with('error', 'Anda tidak memiliki akses ke halaman laporan.');
        }

        $kelasFilter = $request->query('kelas');
        
        // Hitung total siswa (hanya untuk admin, guru_bk, guru)
        if ($user->role === 'siswa') {
            $totalSiswa = 1; // Untuk siswa, total siswa dianggap 1
        } else {
            $totalSiswa = DB::table('data_siswa')->count();
        }

        $jmlPrestasi = 0;
        $jmlMasalah = 0;
        $dataSiswa = [];

        // Query untuk data siswa
        $query = DB::table('penilaian_siswa')
            ->join('data_siswa', 'penilaian_siswa.siswa_id', '=', 'data_siswa.id')
            ->select(
                'data_siswa.id',
                'data_siswa.nama',
                'data_siswa.kelas',
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "prestasi" THEN penilaian_siswa.poin ELSE 0 END) - SUM(CASE WHEN penilaian_siswa.jenis = "pelanggaran" THEN penilaian_siswa.poin ELSE 0 END) AS total_poin'),
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "prestasi" THEN 1 ELSE 0 END) as total_prestasi'),
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "pelanggaran" THEN 1 ELSE 0 END) as total_pelanggaran')
            )
            ->groupBy('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas');

        // Filter berdasarkan kelas
        if ($kelasFilter) {
            $query->where('data_siswa.kelas', $kelasFilter);
        }

        // Filter khusus untuk siswa
        if ($user->role === 'siswa') {
            $siswaId = $user->siswa->id ?? null;
            if ($siswaId) {
                $query->where('data_siswa.id', $siswaId);
                
                // Hitung jumlah prestasi dan pelanggaran untuk siswa ini
                $jmlPrestasi = PenilaianSiswa::where(['jenis' => 'prestasi', 'siswa_id' => $siswaId])->count();
                $jmlMasalah = PenilaianSiswa::where(['jenis' => 'pelanggaran', 'siswa_id' => $siswaId])->count();
            }
        } else {
            // Untuk admin, guru_bk, guru - hitung semua data
            $jmlPrestasi = PenilaianSiswa::where('jenis', 'prestasi')->count();
            $jmlMasalah = PenilaianSiswa::where('jenis', 'pelanggaran')->count();
        }

        $dataSiswa = $query->orderByDesc('total_poin')->get();

        // Hitung presentase (hanya untuk admin, guru_bk, guru)
        if ($user->role === 'siswa') {
            $presentasePrestasi = 0;
            $presentaseMasalah = 0;
        } else {
            $presentasePrestasi = $totalSiswa > 0 ? ($jmlPrestasi / $totalSiswa) * 100 : 0;
            $presentaseMasalah = $totalSiswa > 0 ? ($jmlMasalah / $totalSiswa) * 100 : 0;
        }

        return view('laporan', compact(
            'presentasePrestasi',
            'presentaseMasalah',
            'jmlPrestasi',
            'jmlMasalah',
            'dataSiswa',
            'kelasFilter',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pdf(Request $request)
    {
        // Cek hak akses untuk PDF juga
        $user = Auth::user();
        $allowedRoles = ['admin', 'guru_bk', 'guru', 'siswa'];
        
        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/non_admin')->with('error', 'Anda tidak memiliki akses ke halaman laporan.');
        }

        $kelasFilter = $request->query('kelas');
        
        if ($user->role === 'siswa') {
            $totalSiswa = 1;
        } else {
            $totalSiswa = DB::table('data_siswa')->count();
        }

        $query = DB::table('penilaian_siswa')
            ->join('data_siswa', 'penilaian_siswa.siswa_id', '=', 'data_siswa.id')
            ->select(
                'data_siswa.id', 
                'data_siswa.nama', 
                'data_siswa.kelas',
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "prestasi" THEN penilaian_siswa.poin ELSE 0 END) - SUM(CASE WHEN penilaian_siswa.jenis = "pelanggaran" THEN penilaian_siswa.poin ELSE 0 END) AS total_poin'),
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "prestasi" THEN 1 ELSE 0 END) as total_prestasi'),
                DB::raw('SUM(CASE WHEN penilaian_siswa.jenis = "pelanggaran" THEN 1 ELSE 0 END) as total_pelanggaran')
            )
            ->groupBy('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas');

        if ($kelasFilter) {
            $query->where('data_siswa.kelas', $kelasFilter);
        }

        // Filter khusus untuk siswa di PDF
        if ($user->role === 'siswa') {
            $siswaId = $user->siswa->id ?? null;
            if ($siswaId) {
                $query->where('data_siswa.id', $siswaId);
            }
        }

        $dataSiswa = $query->orderByDesc('total_poin')->get();
        
        if ($user->role === 'siswa') {
            $jmlPrestasi = 0;
            $jmlMasalah = 0;
            $presentasePrestasi = 0;
            $presentaseMasalah = 0;
        } else {
            $jmlPrestasi = PenilaianSiswa::where('jenis', 'prestasi')->count();
            $jmlMasalah = PenilaianSiswa::where('jenis', 'pelanggaran')->count();
            $presentasePrestasi = $totalSiswa > 0 ? ($jmlPrestasi / $totalSiswa) * 100 : 0;
            $presentaseMasalah = $totalSiswa > 0 ? ($jmlMasalah / $totalSiswa) * 100 : 0;
        }

        return view('laporan_pdf', compact(
            'presentasePrestasi',
            'presentaseMasalah',
            'jmlPrestasi',
            'jmlMasalah',
            'dataSiswa',
            'kelasFilter',
        ));
    }

    /**
     * PDF Download method
     */
    public function pdfDownload(Request $request)
    {
        // Implementasi download PDF jika diperlukan
        return $this->pdf($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}