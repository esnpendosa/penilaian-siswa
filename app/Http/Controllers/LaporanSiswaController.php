<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\PenilaianSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelasFilter = $request->query('kelas');
        $totalSiswa = PenilaianSiswa::count();
        $query = DB::table('penilaian_siswa')
            ->join('data_siswa', 'penilaian_siswa.siswa_id', '=', 'data_siswa.id')
            ->select('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas', 
                DB::raw("
                    SUM(CASE WHEN penilaian_siswa.jenis = 'prestasi' THEN penilaian_siswa.poin ELSE 0 END)
                    -
                    SUM(CASE WHEN penilaian_siswa.jenis = 'pelanggaran' THEN penilaian_siswa.poin ELSE 0 END)
                    AS total_poin
                "),
                DB::raw("SUM(penilaian_siswa.jenis = 'prestasi') as total_prestasi"),
                DB::raw("SUM(penilaian_siswa.jenis = 'pelanggaran') as total_pelanggaran"),
            )
            ->groupBy('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas');
        if ($kelasFilter) {
            $query->where('data_siswa.kelas', $kelasFilter);
        }
        $dataSiswa = $query->orderByDesc('total_poin')->get();
        $jmlPrestasi = PenilaianSiswa::where('jenis','prestasi')->count();
        $jmlMasalah = PenilaianSiswa::where('jenis','pelanggaran')->count();
        $presentasePrestasi = $totalSiswa > 0 ? ($jmlPrestasi / $totalSiswa) * 100 : 0;
        $presentaseMasalah = $totalSiswa > 0 ? ($jmlMasalah / $totalSiswa) * 100 : 0;
        return view('laporan', compact(
            'presentasePrestasi', 
            'presentaseMasalah',
            'jmlPrestasi',
            'jmlMasalah',
            'dataSiswa',
            'kelasFilter',
        ));
        // dd($dataSiswa);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pdf(Request $request)
    {
        $kelasFilter = $request->query('kelas');
        $totalSiswa = PenilaianSiswa::count();
        $query = DB::table('penilaian_siswa')
            ->join('data_siswa', 'penilaian_siswa.siswa_id', '=', 'data_siswa.id')
            ->select('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas', 
                DB::raw("
                    SUM(CASE WHEN penilaian_siswa.jenis = 'prestasi' THEN penilaian_siswa.poin ELSE 0 END)
                    -
                    SUM(CASE WHEN penilaian_siswa.jenis = 'pelanggaran' THEN penilaian_siswa.poin ELSE 0 END)
                    AS total_poin
                "),
                DB::raw("SUM(penilaian_siswa.jenis = 'prestasi') as total_prestasi"),
                DB::raw("SUM(penilaian_siswa.jenis = 'pelanggaran') as total_pelanggaran"),
            )
            ->groupBy('data_siswa.id', 'data_siswa.nama', 'data_siswa.kelas');
        if ($kelasFilter) {
            $query->where('data_siswa.kelas', $kelasFilter);
        }
        $dataSiswa = $query->orderByDesc('total_poin')->get();
        $jmlPrestasi = PenilaianSiswa::where('jenis','prestasi')->count();
        $jmlMasalah = PenilaianSiswa::where('jenis','pelanggaran')->count();
        $presentasePrestasi = $totalSiswa > 0 ? ($jmlPrestasi / $totalSiswa) * 100 : 0;
        $presentaseMasalah = $totalSiswa > 0 ? ($jmlMasalah / $totalSiswa) * 100 : 0;
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
