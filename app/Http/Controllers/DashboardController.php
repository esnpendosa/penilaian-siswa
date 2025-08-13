<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\PenilaianSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSiswa = DataSiswa::all();
        $jmlSiswa = DataSiswa::query()->count();

        if (Auth::user()->role === 'siswa') {
            $siswaId = Auth::user()->siswa->id;
            $penilaianSiswa = PenilaianSiswa::query()->where('siswa_id', $siswaId)
                ->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)
                ->orderByDesc('created_at')
                ->get();
            $jmlPrestasi = PenilaianSiswa::query()->where(['jenis' => 'prestasi', 'siswa_id' => $siswaId])->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->count();
            $jmlMasalah = PenilaianSiswa::query()->where(['jenis' => 'pelanggaran', 'siswa_id' => $siswaId])->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->count();
        } else {
            $penilaianSiswa = PenilaianSiswa::orderByDesc('created_at')->get();
            $jmlPrestasi = PenilaianSiswa::query()->where('jenis', 'prestasi')->count();
            $jmlMasalah = PenilaianSiswa::query()->where('jenis', 'pelanggaran')->count();
        }

        // Hitung total poin per siswa
        $poinPerSiswa = DB::table('penilaian_siswa')
            ->select('siswa_id',
                DB::raw('SUM(CASE WHEN jenis = "prestasi" THEN poin ELSE 0 END) - SUM(CASE WHEN jenis = "pelanggaran" THEN poin ELSE 0 END) as total_poin')
            )
            ->groupBy('siswa_id')
            ->pluck('total_poin');
        $rataPoin = $jmlSiswa > 0 ? round($poinPerSiswa->sum() / $jmlSiswa, 1) : 0;

        return view(
            'dashboard',
            compact(
                'dataSiswa',
                'jmlSiswa',
                'jmlPrestasi',
                'jmlMasalah',
                'rataPoin',
                'penilaianSiswa'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function landingPage()
    {
        return view('landingpage');
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
