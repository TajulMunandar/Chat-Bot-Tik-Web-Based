<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = User::class;
    public function definition(): array
    {
        return [
            'username' => 'admin',
            'password' => Hash::make('admin'), // Menggunakan Hash::make() untuk mengenkripsi password
            'nim' => '123123',
            'name' => $this->faker->name(), // Menggunakan $this->faker->name() untuk generate nama secara random
            'isAdmin' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
