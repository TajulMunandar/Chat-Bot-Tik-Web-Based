<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Mahasiswa::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(), // Menggunakan $this->faker->name() untuk generate nama secara random
            'nim' => '123123', // Sesuaikan dengan nim yang ingin Anda tetapkan
            'prodi' => 'Teknologi Informasi', // Sesuaikan dengan prodi yang ingin Anda tetapkan
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
