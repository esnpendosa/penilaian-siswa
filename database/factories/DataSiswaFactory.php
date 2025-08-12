<?php

namespace Database\Factories;

use App\Models\DataSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataSiswa>
 */
class DataSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DataSiswa::class;
    public function definition(): array
    {

        return [
            'nis' => $this->faker->unique()->numerify('#######'), // NIS 7 digit dengan prefix 29001
            'kelas' => $this->faker->randomElement(['X', 'XI', 'XII']), // Kelas X, XI, atau XII
            'nama' => $this->faker->name, // Nama acak
        ];
    }
}
