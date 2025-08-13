<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\DataSiswaFactory> */
    use HasFactory;

    protected $table = 'data_siswa';
    protected $with = "penilaianSiswa";
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'status',
        'user_id',
    ];

    // Getter: ambil hanya 7 digit terakhir
    public function getNisAttribute($value)
    {
        return substr($value, -7);
    }

    // Setter: simpan dengan awalan tetap
    public function setNisAttribute($value)
    {
        $this->attributes['nis'] = '131232750027' . $value;
    }

    public function getFullNisAttribute()
    {
        return $this->attributes['nis'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penilaianSiswa(): HasMany
    {
        return $this->hasMany(PenilaianSiswa::class, 'siswa_id');
    }

}
