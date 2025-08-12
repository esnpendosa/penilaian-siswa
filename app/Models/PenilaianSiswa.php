<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\PenilaianSiswaFactory> */
    use HasFactory;

    protected $table = 'penilaian_siswa';

    protected $fillable = [
        'siswa_id',
        'nama_siswa',
        'jenis',
        'kategori',
        'tanggal',
        'keterangan',
        'poin',
    ];
}
