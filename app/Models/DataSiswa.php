<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\DataSiswaFactory> */
    use HasFactory;

    protected $table = 'data_siswa';
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'status',
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

    public function getFullNisAttribute(){
        return $this->attributes['nis'];
    }

}
