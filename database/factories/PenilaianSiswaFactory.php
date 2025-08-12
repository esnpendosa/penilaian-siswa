<?php

namespace Database\Factories;

use App\Models\DataSiswa;
use App\Models\PenilaianSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenilaianSiswa>
 */
class PenilaianSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PenilaianSiswa::class;
     public function definition(): array
    {
        // Ambil siswa acak untuk relasi
        $siswa = DataSiswa::inRandomOrder()->first();

        return [
            'siswa_id' => $siswa->id,  // Ambil siswa_id dari data siswa yang acak
            'nama_siswa' => $siswa->nama,  // Ambil nama siswa dari data siswa yang acak
            'jenis' => $this->faker->randomElement(['prestasi', 'pelanggaran']),
            'kategori' => $this->faker->randomElement(['akademik', 'nonakademik']),
            'tanggal' => $this->faker->date(),
            'keterangan' => $this->faker->sentence(),
            'poin' => $this->faker->numberBetween(1, 100),
        ];
    }
    
}
